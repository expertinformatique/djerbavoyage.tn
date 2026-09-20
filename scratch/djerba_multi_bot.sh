#!/bin/bash
# ==============================================================================
# Djerba Voyage & Multi-Site — Multi-Bot Universal Execution Runner
# Target Server: 192.168.0.129
# Supports custom target websites, CMS endpoints and Facebook Pages per Bot
# ==============================================================================

BOT_ID="${1:-bot_guide_patrimoine}"
GLOBAL_LOG="/var/log/djerba_bot.log"
BOT_LOG="/var/log/djerba_bot_${BOT_ID}.log"
BOTS_FILE="/var/www/html/data/bots.json"
MAX_LOG_SIZE=5242880

# Ensure log files exist and have correct permissions
touch "$GLOBAL_LOG" "$BOT_LOG" 2>/dev/null
chmod 666 "$GLOBAL_LOG" "$BOT_LOG" 2>/dev/null

# Log rotation if > 5 MB
for LF in "$GLOBAL_LOG" "$BOT_LOG"; do
    if [ -f "$LF" ]; then
        FILE_SIZE=$(stat -c%s "$LF" 2>/dev/null || echo 0)
        if [ "$FILE_SIZE" -gt "$MAX_LOG_SIZE" ]; then
            mv -f "$LF" "${LF}.1"
            touch "$LF"
            chmod 666 "$LF"
        fi
    fi
done

# Defaults
THEME=""
TEXT_AGENT="gemini-2.5-flash"
IMAGE_AGENT="nano-banana"
VIDEO_AGENT="reel-5photo-kenburns"
CATEGORIES="all"
API_ENDPOINT="https://djerbavoyage.tn/api/auto-blog/generate"
API_SECRET_TOKEN="djerba_secret_cron_key_2026"
SITE_URL="https://djerbavoyage.tn"
SITE_NAME="Djerba Voyage"
FB_PAGE_NAME=""
FB_PAGE_ID=""
FB_TOKEN=""

if [ -f "$BOTS_FILE" ]; then
    BOT_PARAMS=$(php -r "
        \$data = @json_decode(file_get_contents('$BOTS_FILE'), true);
        foreach (\$data['bots'] ?? [] as \$b) {
            if (\$b['id'] === '$BOT_ID') {
                \$cats = is_array(\$b['categories'] ?? null) ? implode(',', \$b['categories']) : (\$b['categories'] ?? 'all');
                echo urlencode(\$b['theme'] ?? '') . ' ' .
                     urlencode(\$b['ai_agents']['text'] ?? 'gemini-2.5-flash') . ' ' .
                     urlencode(\$b['ai_agents']['image'] ?? 'nano-banana') . ' ' .
                     urlencode(\$b['ai_agents']['video'] ?? 'reel-5photo-kenburns') . ' ' .
                     urlencode(\$b['target_destination']['api_endpoint'] ?? 'https://djerbavoyage.tn/api/auto-blog/generate') . ' ' .
                     urlencode(\$b['target_destination']['api_secret_token'] ?? 'djerba_secret_cron_key_2026') . ' ' .
                     urlencode(\$b['target_destination']['site_url'] ?? 'https://djerbavoyage.tn') . ' ' .
                     urlencode(\$b['target_destination']['site_name'] ?? 'Djerba Voyage') . ' ' .
                     urlencode(\$b['social_destinations']['facebook_page_name'] ?? '') . ' ' .
                     urlencode(\$b['social_destinations']['facebook_page_id'] ?? '') . ' ' .
                     ((\$b['channels']['facebook_story'] ?? true) ? '1' : '0') . ' ' .
                     urlencode(\$cats);
                break;
            }
        }
    " 2>/dev/null)
    
    if [ -n "$BOT_PARAMS" ]; then
        read -r THEME TEXT_AGENT IMAGE_AGENT VIDEO_AGENT API_ENDPOINT API_SECRET_TOKEN SITE_URL SITE_NAME FB_PAGE_NAME FB_PAGE_ID HAS_STORY CATEGORIES <<< "$BOT_PARAMS"
    fi
fi

# Decode URL encoded variables for cURL URL
DECODED_ENDPOINT=$(php -r "echo urldecode('$API_ENDPOINT');" 2>/dev/null || echo "https://djerbavoyage.tn/api/auto-blog/generate")
DECODED_TOKEN=$(php -r "echo urldecode('$API_SECRET_TOKEN');" 2>/dev/null || echo "djerba_secret_cron_key_2026")
DECODED_SITE_NAME=$(php -r "echo urldecode('$SITE_NAME');" 2>/dev/null || echo "Djerba Voyage")
DECODED_FB_PAGE=$(php -r "echo urldecode('$FB_PAGE_NAME');" 2>/dev/null || echo "")

SEP="?"
if [[ "$DECODED_ENDPOINT" == *"?"* ]]; then
    SEP="&"
fi

API_URL="${DECODED_ENDPOINT}${SEP}token=${DECODED_TOKEN}&bot_id=${BOT_ID}&theme=${THEME}&text_agent=${TEXT_AGENT}&image_agent=${IMAGE_AGENT}&video_agent=${VIDEO_AGENT}&site_url=${SITE_URL}&site_name=${SITE_NAME}&fb_page_id=${FB_PAGE_ID}&fb_page_name=${FB_PAGE_NAME}&story=${HAS_STORY:-1}&categories=${CATEGORIES:-all}"

log_msg() {
    echo "$1" >> "$GLOBAL_LOG"
    echo "$1" >> "$BOT_LOG"
}

log_msg "========================================================"
log_msg "[$(date '+%Y-%m-%d %H:%M:%S')] Démarrage cycle pour bot: ${BOT_ID}"
log_msg "  - Cible Web: ${DECODED_SITE_NAME} (${DECODED_ENDPOINT})"
if [ -n "$DECODED_FB_PAGE" ]; then
    log_msg "  - Page Facebook: ${DECODED_FB_PAGE}"
fi
log_msg "  - Agents IA: Texte=${TEXT_AGENT}, Image=${IMAGE_AGENT}, Vidéo=${VIDEO_AGENT}"
log_msg "  - Story 9:16: $([ "${HAS_STORY}" = "1" ] && echo "Activée" || echo "Désactivée")"

SUCCESS=0
for ATTEMPT in 1 2 3; do
    log_msg "[$(date '+%Y-%m-%d %H:%M:%S')] Appel API (Tentative $ATTEMPT/3)..."
    RESPONSE=$(curl -s -S --max-time 180 -H "X-Auto-Blog-Token: ${DECODED_TOKEN}" "$API_URL" 2>&1)
    EXIT_CODE=$?

    if [ $EXIT_CODE -eq 0 ] && echo "$RESPONSE" | grep -q '"success":\s*true'; then
        log_msg "$RESPONSE"
        log_msg "[$(date '+%Y-%m-%d %H:%M:%S')] ✅ Cycle terminé avec succès pour bot: ${BOT_ID} à la tentative $ATTEMPT"
        SUCCESS=1
        break
    else
        log_msg "[$(date '+%Y-%m-%d %H:%M:%S')] ⚠️ Tentative $ATTEMPT échouée (Code: $EXIT_CODE): $RESPONSE"
        if [ $ATTEMPT -lt 3 ]; then
            sleep 8
        fi
    fi
done

if [ $SUCCESS -ne 1 ]; then
    log_msg "[$(date '+%Y-%m-%d %H:%M:%S')] ❌ ÉCHEC CRITIQUE pour bot: ${BOT_ID} après 3 tentatives"
fi
log_msg "========================================================"

if [ $SUCCESS -eq 1 ]; then
    exit 0
else
    exit 1
fi
