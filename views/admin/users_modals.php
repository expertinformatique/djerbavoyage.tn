<!-- Modal Création Utilisateur -->
<div id="createUserModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl w-full max-w-md overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
      <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-user-add text-[#635bff]"></i>
        Ajouter un utilisateur
      </h3>
      <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-lg leading-none">&times;</button>
    </div>
    <form method="POST" action="<?= url('/admin/users/create') ?>" class="p-5 space-y-4 text-xs">
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Identifiant (Username) *</label>
        <input type="text" name="username" required placeholder="ex: sarah_djerba" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Adresse E-mail *</label>
        <input type="email" name="email" required placeholder="sarah@djerbavoyage.tn" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Rôle *</label>
        <select name="role" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
          <option value="admin">Administrateur (Tous les droits)</option>
          <option value="editor">Éditeur (Blog, Contenus & Produits)</option>
          <option value="agent">Agent (Commandes & Réservations)</option>
        </select>
      </div>
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Mot de passe provisoire *</label>
        <input type="password" name="password" minlength="6" required placeholder="Au moins 6 caractères" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2">
        <button type="button" onclick="closeCreateModal()" class="px-3.5 py-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md font-medium transition-colors">Annuler</button>
        <button type="submit" class="px-4 py-2 bg-[#635bff] hover:bg-[#5349e0] text-white rounded-md font-semibold transition-colors">Créer le compte</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Édition Utilisateur -->
<div id="editUserModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
  <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl w-full max-w-md overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
      <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
        <i class="fi fi-rr-edit text-[#635bff]"></i>
        Modifier l'utilisateur
      </h3>
      <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-lg leading-none">&times;</button>
    </div>
    <form method="POST" action="<?= url('/admin/users/update') ?>" class="p-5 space-y-4 text-xs">
      <input type="hidden" name="id" id="editUserId">
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Identifiant (Username) *</label>
        <input type="text" name="username" id="editUsername" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Adresse E-mail *</label>
        <input type="email" name="email" id="editEmail" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Rôle *</label>
        <select name="role" id="editRole" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
          <option value="admin">Administrateur</option>
          <option value="editor">Éditeur</option>
          <option value="agent">Agent</option>
        </select>
      </div>
      <div>
        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
        <input type="password" name="password" minlength="6" placeholder="Optionnel" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-md focus:outline-hidden focus:ring-1 focus:ring-[#635bff]">
      </div>
      <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2">
        <button type="button" onclick="closeEditModal()" class="px-3.5 py-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md font-medium transition-colors">Annuler</button>
        <button type="submit" class="px-4 py-2 bg-[#635bff] hover:bg-[#5349e0] text-white rounded-md font-semibold transition-colors">Enregistrer</button>
      </div>
    </form>
  </div>
</div>
