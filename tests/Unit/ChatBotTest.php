<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\ChatConversation;
use App\Repositories\PdoChatConversationRepository;
use App\Services\ChatKnowledgeService;
use App\Services\GoogleAiService;
use App\Services\SmtpMailerService;
use App\Controllers\ChatBotController;
use Core\Database;

/**
 * Tests Unitaires pour le ChatBot IA et Repository
 */
class ChatBotTest extends TestCase
{
    private PdoChatConversationRepository $repo;
    private ChatKnowledgeService $knowledge;

    public function runSetUp(): void
    {
        $pdo = Database::getInstance();
        $this->repo = new PdoChatConversationRepository($pdo);
        $googleAi = new GoogleAiService(null, true); // dryRun
        $this->knowledge = new ChatKnowledgeService($googleAi);
    }

    public function testSaveAndFindChatConversation(): void
    {
        $conv = new ChatConversation([
            'id' => 'CHAT-TEST1',
            'session_id' => 'sess_test_123',
            'client_name' => 'Jean Dupont',
            'client_email' => 'jean@test.com',
            'client_phone' => '+33600000000',
            'detected_need' => 'Réservation Excursions & Quads',
            'summary' => 'Demande de tarif pour 2 quads',
            'ip_hash' => hash('sha256', '127.0.0.1'),
            'status' => 'active'
        ]);
        $conv->setMessages([
            ['role' => 'user', 'content' => 'Bonjour, quel est le prix du quad ?', 'time' => '10:00']
        ]);

        $saved = $this->repo->save($conv);
        $this->assertTrue($saved);

        $found = $this->repo->findById('CHAT-TEST1');
        $this->assertNotNull($found);
        $this->assertEquals('Jean Dupont', $found->getClientName());
        $this->assertEquals('jean@test.com', $found->getClientEmail());
        $this->assertCount(1, $found->getMessages());

        $bySession = $this->repo->findBySessionId('sess_test_123');
        $this->assertNotNull($bySession);
        $this->assertEquals('CHAT-TEST1', $bySession->getId());
    }

    public function testDeleteAndArchiveChatConversation(): void
    {
        $conv = new ChatConversation([
            'id' => 'CHAT-DEL1',
            'session_id' => 'sess_del_999',
            'ip_hash' => hash('sha256', '127.0.0.1'),
            'status' => 'active'
        ]);
        $this->repo->save($conv);

        $deleted = $this->repo->deleteBySessionId('sess_del_999');
        $this->assertTrue($deleted);

        $this->assertNull($this->repo->findBySessionId('sess_del_999'));
    }

    public function testAnalyzeIntentAndNeedLabel(): void
    {
        $intent1 = $this->knowledge->analyzeIntent("Je voudrais réserver un quad et faire du kitesurf");
        $this->assertEquals('activities', $intent1['category']);

        $intent2 = $this->knowledge->analyzeIntent("Quel est le prix du Pass Djerba Expérience tout compris ?");
        $this->assertEquals('pass', $intent2['category']);

        $intent3 = $this->knowledge->analyzeIntent("Navette aéroport Djerba Zarzis avec chauffeur");
        $this->assertEquals('transfer', $intent3['category']);
    }

    public function testChatBotControllerFlow(): void
    {
        $controller = new ChatBotController($this->repo, $this->knowledge);
        $sessId = 'sess_flow_' . uniqid();

        $res = $controller->handle([
            'session_id' => $sessId,
            'message' => 'Bonjour, quelles sont vos excursions en mer ?'
        ], '127.0.0.1', 'fr');

        $this->assertTrue($res['success']);
        $this->assertNotEmpty($res['reply']);
        $this->assertEquals($sessId, $res['session_id']);

        $conv = $this->repo->findBySessionId($sessId);
        $this->assertNotNull($conv);
        $this->assertCount(2, $conv->getMessages()); // 1 user + 1 assistant
    }

    public function testContactExtractionAndSaveContact(): void
    {
        $controller = new ChatBotController($this->repo, $this->knowledge);
        $sessId = 'sess_contact_' . uniqid();

        // 1. Envoi message avec email dans le texte
        $res = $controller->handle([
            'session_id' => $sessId,
            'message' => 'Mon email est voyageur@djerbavoyage.tn et mon tél est 0612345678'
        ], '127.0.0.1', 'fr');

        $this->assertTrue($res['success']);
        $conv = $this->repo->findBySessionId($sessId);
        $this->assertEquals('voyageur@djerbavoyage.tn', $conv->getClientEmail());
        $this->assertEquals('0612345678', $conv->getClientPhone());

        // 2. Action save_contact
        $res2 = $controller->handle([
            'action' => 'save_contact',
            'session_id' => $sessId,
            'client_name' => 'Sarah Connor',
            'client_email' => 'sarah@skynet.com',
            'client_phone' => '+33699887766'
        ], '127.0.0.1', 'fr');

        $this->assertTrue($res2['success']);
        $this->assertTrue($res2['contact_saved']);

        $convUpdated = $this->repo->findBySessionId($sessId);
        $this->assertEquals('Sarah Connor', $convUpdated->getClientName());
        $this->assertEquals('contact_provided', $convUpdated->getStatus());
    }

    public function testContactPromptTriggeredAfterMultipleAssistantTurns(): void
    {
        $fallbackKnowledge = new ChatKnowledgeService(new GoogleAiService(null, false)); // No API key, forces fallback
        $history = [
            ['role' => 'user', 'content' => 'Question 1'],
            ['role' => 'assistant', 'content' => 'Réponse 1'],
            ['role' => 'user', 'content' => 'Question 2'],
            ['role' => 'assistant', 'content' => 'Réponse 2'],
        ];

        $reply = $fallbackKnowledge->generateFallbackReply("Je voudrais réserver", $history, 'fr');
        $this->assertEquals('ask_contact', $reply['action']);
        $this->assertStringContainsString("coordonnées", $reply['action_label']);
    }

    public function testMultiLanguageFallbackSupport(): void
    {
        $fallbackKnowledge = new ChatKnowledgeService(new GoogleAiService(null, false));
        $replyFr = $fallbackKnowledge->generateFallbackReply("Pass djerba", [], 'fr');
        $replyEn = $fallbackKnowledge->generateFallbackReply("Pass djerba", [], 'en');
        $replyAr = $fallbackKnowledge->generateFallbackReply("Pass djerba", [], 'ar');

        $this->assertStringContainsString("Pass", $replyFr['text']);
        $this->assertStringContainsString("Pass", $replyEn['text']);
        $this->assertStringContainsString("باقة", $replyAr['text']);
    }

    public function testSendSummaryAction(): void
    {
        $controller = new ChatBotController($this->repo, $this->knowledge);
        $sessId = 'sess_summary_' . uniqid();

        $controller->handle([
            'session_id' => $sessId,
            'message' => 'Je veux visiter Djerbahood et faire du quad'
        ], '127.0.0.1', 'fr');

        $res = $controller->handle([
            'action' => 'send_summary',
            'session_id' => $sessId,
            'history' => [
                ['role' => 'user', 'content' => 'Je veux visiter Djerbahood et faire du quad']
            ]
        ], '127.0.0.1', 'fr');

        $this->assertTrue($res['success']);
        $conv = $this->repo->findBySessionId($sessId);
        $this->assertEquals('completed', $conv->getStatus());
    }
}
