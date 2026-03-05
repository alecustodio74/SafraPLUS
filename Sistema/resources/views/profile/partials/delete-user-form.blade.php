<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-[#db2728]">Excluir Conta</h2>
        <p class="mt-4 text-sm text-gray-500">
            Depois que sua conta for excluída, todos os seus recursos e dados (incluindo safras, finanças, etc.) serão permanentemente apagados e não poderão ser recuperados.
        </p>
    </header>

    <div>
        <button type="button" class="px-6 py-2.5 bg-[#db2728] text-white font-semibold rounded-xl hover:bg-red-700 transition-colors shadow-sm" onclick="document.getElementById('confirmUserDeletionModal').classList.remove('hidden')">
            Excluir Minha Conta
        </button>
    </div>

    <!-- Vanilla JS Modal Overlay -->
    <div id="confirmUserDeletionModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('confirmUserDeletionModal').classList.add('hidden')"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full relative">
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="p-8 pb-4 relative bg-white">
                        <!-- Red Line above the title -->
                        <div class="absolute inset-x-0 top-0 h-1.5 bg-[#db2728]"></div>
                        
                        <h5 class="font-bold text-xl text-gray-900 mt-2" id="modalLabel">Tem certeza que deseja excluir sua conta?</h5>
                        
                        <hr class="my-6 border-gray-100" />
                        
                        <p class="text-sm text-gray-500 mb-6">
                            Por favor, digite sua senha para confirmar que você deseja excluir permanentemente sua conta. Esta ação <strong>não pode ser desfeita</strong>.
                        </p>

                        <div>
                            <label for="password_delete" class="block text-sm font-medium text-gray-700 mb-2">Sua Senha</label>
                            <input id="password_delete" name="password" type="password" class="w-full bg-white border border-gray-200 text-gray-900 rounded-xl focus:ring-[#db2728] focus:border-[#db2728] px-4 py-3 transition-colors outline-none @error('password', 'userDeletion') border-red-500 ring-red-500 @enderror" placeholder="********" required>
                            
                            @error('password', 'userDeletion')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 px-8 py-4 flex justify-end gap-4 border-t border-gray-100">
                        <button type="button" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm" onclick="document.getElementById('confirmUserDeletionModal').classList.add('hidden')">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#db2728] text-white font-semibold rounded-xl hover:bg-red-700 transition-colors shadow-sm">
                            Excluir Conta Permanentemente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>