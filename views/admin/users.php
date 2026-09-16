<?php
/**
 * Vue d'administration : Gestion des Utilisateurs
 * Charte Stripe dense, responsive mobile, zéro inline style
 * 
 * @var array $users
 * @var string $currentAdmin
 * @var string|null $flashSuccess
 * @var string|null $flashError
 */
?>

<div class="p-4 sm:p-6 space-y-6 max-w-7xl mx-auto">

  <!-- En-tête de page -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="<?= url('/admin/dashboard') ?>" class="hover:text-slate-700 dark:hover:text-slate-300">Dashboard</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-slate-100 font-medium">Sécurité</span>
        <span>/</span>
        <span class="text-[#635bff] font-medium">Utilisateurs</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
        <i class="fi fi-rr-users text-[#635bff]"></i>
        Gestion des Utilisateurs
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
        Contrôlez les accès à la plateforme d'administration et gérez les rôles d'équipe.
      </p>
    </div>

    <div>
      <button type="button" onclick="openCreateModal()" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-white bg-[#635bff] hover:bg-[#5349e0] rounded-md shadow-sm transition-colors">
        <i class="fi fi-rr-user-add text-sm"></i>
        <span>Nouvel Utilisateur</span>
      </button>
    </div>
  </div>

  <!-- Messages Flash -->
  <?php if (!empty($flashSuccess)): ?>
    <div class="p-3.5 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-check-circle text-emerald-600 dark:text-emerald-400 text-sm"></i>
        <span><?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <?php if (!empty($flashError)): ?>
    <div class="p-3.5 text-xs font-medium text-rose-800 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 rounded-lg flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fi fi-rr-cross-circle text-rose-600 dark:text-rose-400 text-sm"></i>
        <span><?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 text-sm">&times;</button>
    </div>
  <?php endif; ?>

  <!-- Tableau des comptes -->
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-sm overflow-hidden">
    <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
      <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
        Comptes enregistrés (<?= count($users) ?>)
      </span>
      <span class="text-[11px] text-slate-400">Authentification chiffrée bcrypt</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs">
        <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 uppercase text-[10px] font-semibold tracking-wider border-b border-slate-200 dark:border-slate-800">
          <tr>
            <th class="px-4 py-3">Utilisateur</th>
            <th class="px-4 py-3">E-mail</th>
            <th class="px-4 py-3">Rôle & Privilèges</th>
            <th class="px-4 py-3">Date de Création</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-200">
          <?php foreach ($users as $user): ?>
            <?php 
              $isSelf = ($user->username === $currentAdmin);
              $roleClasses = match($user->role) {
                'admin'  => 'bg-purple-50 dark:bg-purple-950/50 text-purple-700 dark:text-purple-300 border-purple-200 dark:border-purple-800/60',
                'editor' => 'bg-sky-50 dark:bg-sky-950/50 text-sky-700 dark:text-sky-300 border-sky-200 dark:border-sky-800/60',
                default  => 'bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800/60',
              };
            ?>
            <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
              <td class="px-4 py-2.5 flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-full bg-slate-100 dark:bg-slate-800 text-[#635bff] font-bold flex items-center justify-center text-xs shrink-0 border border-slate-200 dark:border-slate-700">
                  <?= strtoupper(substr($user->username, 0, 1)) ?>
                </div>
                <div>
                  <span class="font-semibold text-slate-900 dark:text-white"><?= htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8') ?></span>
                  <?php if ($isSelf): ?>
                    <span class="ml-1.5 px-1.5 py-0.5 text-[9px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 rounded">Vous</span>
                  <?php endif; ?>
                </div>
              </td>
              <td class="px-4 py-2.5 text-slate-500 dark:text-slate-400">
                <?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') ?>
              </td>
              <td class="px-4 py-2.5">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-semibold border rounded-full <?= $roleClasses ?>">
                  <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                  <?= ucfirst($user->role) ?>
                </span>
              </td>
              <td class="px-4 py-2.5 text-slate-400 text-[11px]">
                <?= date('d/m/Y H:i', strtotime($user->createdAt ?? 'now')) ?>
              </td>
              <td class="px-4 py-2.5 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <button type="button" 
                          onclick="openEditModal(<?= $user->id ?>, '<?= htmlspecialchars(addslashes($user->username), ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars(addslashes($user->email), ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars(addslashes($user->role), ENT_QUOTES, 'UTF-8') ?>')"
                          class="p-1.5 text-slate-500 hover:text-[#635bff] dark:text-slate-400 dark:hover:text-[#818cf8] rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                          title="Modifier l'utilisateur">
                    <i class="fi fi-rr-edit text-xs"></i>
                  </button>

                  <?php if (!$isSelf): ?>
                    <form method="POST" action="<?= url('/admin/users/delete') ?>" onsubmit="return confirm('Confirmez-vous la suppression du compte <?= htmlspecialchars(addslashes($user->username), ENT_QUOTES, 'UTF-8') ?> ?')" class="inline">
                      <input type="hidden" name="id" value="<?= $user->id ?>">
                      <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Supprimer">
                        <i class="fi fi-rr-trash text-xs"></i>
                      </button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__ . '/users_modals.php'; ?>


<script>
function openCreateModal() {
  document.getElementById('createUserModal').classList.remove('hidden');
}
function closeCreateModal() {
  document.getElementById('createUserModal').classList.add('hidden');
}
function openEditModal(id, username, email, role) {
  document.getElementById('editUserId').value = id;
  document.getElementById('editUsername').value = username;
  document.getElementById('editEmail').value = email;
  document.getElementById('editRole').value = role;
  document.getElementById('editUserModal').classList.remove('hidden');
}
function closeEditModal() {
  document.getElementById('editUserModal').classList.add('hidden');
}
</script>
