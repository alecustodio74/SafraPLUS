<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-600">
            Excluir Conta
        </h2>

        <p class="mt-1 text-sm text-slate-500 max-w-xl">
            Depois que sua conta for excluída, todos os seus recursos e dados (incluindo safras, finanças, etc.) serão permanentemente apagados e não poderão ser recuperados.
        </p>
    </header>

    <div x-data="{ confirmingUserDeletion: false }">
        <button type="button" @click="confirmingUserDeletion = true" class="inline-flex justify-center items-center px-6 py-2.5 bg-red-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-red-500/30 hover:bg-red-700 hover:shadow-lg hover:shadow-red-600/40 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200">
            Excluir Minha Conta
        </button>

        <!-- Modal -->
        <div x-show="confirmingUserDeletion" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="confirmingUserDeletion" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" 
                     @click="confirmingUserDeletion = false" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="confirmingUserDeletion"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-100">
                    
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">
                                        Tem certeza que deseja excluir sua conta?
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-500">
                                            Por favor, digite sua senha para confirmar que você deseja excluir permanentemente sua conta. Esta ação não pode ser desfeita.
                                        </p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label for="password" class="sr-only">Senha</label>
                                        <input type="password" name="password" id="password" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm px-4 py-2.5" placeholder="Sua senha atual" required x-ref="password" @focus="setTimeout(() => $refs.password.focus(), 50)">
                                        @error('password', 'userDeletion')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-slate-50 px-4 py-3 sm:px-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                            <button type="button" @click="confirmingUserDeletion = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-colors">
                                Excluir Conta Permanentemente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>