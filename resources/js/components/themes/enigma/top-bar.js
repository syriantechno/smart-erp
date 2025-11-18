(function () {
    "use strict";

    let searchModal = null;
    const searchTriggers = document.querySelectorAll('[data-search-trigger]');

    // Function to open modal
    function openSearchModal() {
        if (searchModal) {
            searchModal.remove();
        }
        
        // Create modal with black background
        searchModal = document.createElement('div');
        searchModal.id = 'global-search-modal';
        searchModal.style.cssText = 'position:fixed!important;top:0!important;left:0!important;right:0!important;bottom:0!important;z-index:999999!important;background:rgba(0,0,0,0.65)!important;backdrop-filter:blur(10px)!important;-webkit-backdrop-filter:blur(10px)!important;display:flex!important;align-items:flex-start!important;justify-content:center!important;padding-top:10vh!important;padding:1rem!important;';
        
        searchModal.innerHTML = '<div class="fixed inset-0 overflow-y-auto"><div class="flex justify-center my-2 sm:mt-40"><div class="sm:w-[600px] lg:w-[700px] w-[95%] relative mx-auto transition-transform" id="headlessui-dialog-panel-:rd:" data-headlessui-state="open" style="opacity:1!important;"><div class="relative"><div class="absolute inset-y-0 left-0 flex items-center justify-center w-12"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-5 h-5 -mr-1.5 text-slate-500 stroke-[1]"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg></div><input id="global-search-modal-input" class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-700/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-700/50 transition duration-200 ease-in-out w-full border-slate-300/60 placeholder:text-slate-400/90 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-700 dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80 pl-12 pr-14 py-3.5 text-base rounded-lg focus:ring-0 border-0 shadow-lg" type="text" placeholder="Quick search..." value=""><div class="absolute inset-y-0 right-0 flex items-center w-14"><div id="search-close-btn" class="px-2 py-1 mr-auto text-xs border rounded-[0.4rem] bg-slate-100 text-slate-500/80 dark:bg-darkmode-500 cursor-pointer">ESC</div></div></div><div class="relative z-10 pb-1 mt-1 bg-white rounded-lg shadow-lg max-h-[468px] sm:max-h-[615px] overflow-y-auto dark:bg-darkmode-800"><div><div class="px-5 py-4"><div class="flex items-center"><div class="text-xs uppercase text-slate-500">Start your search here...</div></div><div class="flex flex-wrap gap-2 mt-3.5"><a href="" class="flex items-center gap-x-1.5 border rounded-full px-3 py-0.5 border-slate-300/70 hover:bg-slate-50 dark:hover:bg-darkmode-500"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round w-4 h-4 stroke-[1.3]"><path d="M18 21a8 8 0 0 0-16 0"></path><circle cx="10" cy="8" r="5"></circle><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path></svg>Users</a><a href="" class="flex items-center gap-x-1.5 border rounded-full px-3 py-0.5 border-slate-300/70 hover:bg-slate-50 dark:hover:bg-darkmode-500"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2 w-4 h-4 stroke-[1.3]"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path><path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path></svg>Departments</a><a href="" class="flex items-center gap-x-1.5 border rounded-full px-3 py-0.5 border-slate-300/70 hover:bg-slate-50 dark:hover:bg-darkmode-500"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-kanban-square w-4 h-4 stroke-[1.3]"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M8 7v7"></path><path d="M12 7v4"></path><path d="M16 7v9"></path></svg>Products</a><a href="" class="flex items-center gap-x-1.5 border rounded-full px-3 py-0.5 border-slate-300/70 hover:bg-slate-50 dark:hover:bg-darkmode-500"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-check w-4 h-4 stroke-[1.3]"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"></path><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path><path d="m16 19 2 2 4-4"></path></svg>Mails</a></div></div><div class="px-5 py-4 border-t border-dashed"><div class="flex items-center"><div class="text-xs uppercase text-slate-500">Users</div><a class="ml-auto text-xs text-slate-500" href="">See All</a></div><div class="flex flex-col gap-1 mt-3.5"><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="w-6 h-6 overflow-hidden border-2 rounded-full image-fit zoom-in border-slate-200/70 box"><img alt="User" src="https://via.placeholder.com/32x32.png"></div><div class="font-medium truncate">Jennifer Lawrence</div><div class="hidden text-slate-500 sm:block">Miami, USA</div></a><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="w-6 h-6 overflow-hidden border-2 rounded-full image-fit zoom-in border-slate-200/70 box"><img alt="User" src="https://via.placeholder.com/32x32.png"></div><div class="font-medium truncate">Johnny Depp</div><div class="hidden text-slate-500 sm:block">Denver, USA</div></a><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="w-6 h-6 overflow-hidden border-2 rounded-full image-fit zoom-in border-slate-200/70 box"><img alt="User" src="https://via.placeholder.com/32x32.png"></div><div class="font-medium truncate">Leonardo DiCaprio</div><div class="hidden text-slate-500 sm:block">Chicago, USA</div></a></div></div><div class="px-5 py-4 border-t border-dashed"><div class="flex items-center"><div class="text-xs uppercase text-slate-500">Departments</div><a class="ml-auto text-xs text-slate-500" href="">See All</a></div><div class="flex flex-col gap-1 mt-3.5"><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="flex items-center justify-center w-6 h-6 overflow-hidden border rounded-md zoom-in border-theme-1/10 box bg-theme-1/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-store w-3.5 h-3.5 stroke-[1.3] text-theme-1"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path><path d="M2 7h20"></path><path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"></path></svg></div><div class="font-medium truncate">Engineering</div><div class="hidden text-slate-500 sm:block">Eswatini</div></a><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="flex items-center justify-center w-6 h-6 overflow-hidden border rounded-md zoom-in border-theme-1/10 box bg-theme-1/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-store w-3.5 h-3.5 stroke-[1.3] text-theme-1"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path><path d="M2 7h20"></path><path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"></path></svg></div><div class="font-medium truncate">Research and Development</div><div class="hidden text-slate-500 sm:block">Zimbabwe</div></a><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="flex items-center justify-center w-6 h-6 overflow-hidden border rounded-md zoom-in border-theme-1/10 box bg-theme-1/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-store w-3.5 h-3.5 stroke-[1.3] text-theme-1"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path><path d="M2 7h20"></path><path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"></path></svg></div><div class="font-medium truncate">Product Management</div><div class="hidden text-slate-500 sm:block">Martinique</div></a></div></div><div class="px-5 py-4 border-t border-dashed"><div class="flex items-center"><div class="text-xs uppercase text-slate-500">Products</div><a class="ml-auto text-xs text-slate-500" href="">See All</a></div><div class="flex flex-col gap-1 mt-3.5"><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="w-6 h-6 overflow-hidden border-2 rounded-full image-fit zoom-in border-slate-200/70 box"><img alt="Product" src="https://via.placeholder.com/32x32.png"></div><div class="font-medium truncate">Wireless Earbuds with Mic</div><div class="hidden text-slate-500 sm:block">Beauty & Personal Care</div></a><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="w-6 h-6 overflow-hidden border-2 rounded-full image-fit zoom-in border-slate-200/70 box"><img alt="Product" src="https://via.placeholder.com/32x32.png"></div><div class="font-medium truncate">8-Cup Coffee Maker</div><div class="hidden text-slate-500 sm:block">Books</div></a><a href="" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500"><div class="w-6 h-6 overflow-hidden border-2 rounded-full image-fit zoom-in border-slate-200/70 box"><img alt="Product" src="https://via.placeholder.com/32x32.png"></div><div class="font-medium truncate">Smartphone Charging Dock</div><div class="hidden text-slate-500 sm:block">Toys & Games</div></a></div></div></div></div></div></div></div>';
        
        document.body.appendChild(searchModal);
        document.body.style.overflow = 'hidden';
        
        // Add event listeners
        const closeBtn = document.getElementById('search-close-btn');
        const searchInput = document.getElementById('global-search-modal-input');
        
        if (closeBtn) {
            closeBtn.addEventListener('click', closeSearchModal);
        }
        
        searchModal.addEventListener('click', (e) => {
            if (e.target === searchModal) {
                closeSearchModal();
            }
        });
        
        if (searchInput) {
            searchInput.focus();
            
            // Add search functionality
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (query.length >= 2) {
                        performSearch(query);
                    } else {
                        resetSearchResults();
                    }
                }, 300);
            });
        }
    }

    // Function to close modal
    function closeSearchModal() {
        if (searchModal) {
            searchModal.remove();
            searchModal = null;
            document.body.style.overflow = '';
        }
    }

    // Search functions
    function performSearch(query) {
        // Show loading state
        showSearchLoading();
        
        fetch(`/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                updateSearchResults(data);
            })
            .catch(error => {
                console.error('Search error:', error);
                showSearchError();
            });
    }

    function showSearchLoading() {
        const resultsContainer = document.querySelector('#global-search-modal .relative.z-10');
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div class="px-5 py-8 text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary mx-auto"></div>
                    <div class="mt-2 text-slate-500">Searching...</div>
                </div>
            `;
        }
    }

    function showSearchError() {
        const resultsContainer = document.querySelector('#global-search-modal .relative.z-10');
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div class="px-5 py-8 text-center">
                    <div class="text-red-500 mb-2">⚠️</div>
                    <div class="text-slate-500">Search error occurred</div>
                </div>
            `;
        }
    }

    function updateSearchResults(data) {
        const resultsContainer = document.querySelector('#global-search-modal .relative.z-10');
        if (!resultsContainer) return;

        let html = '<div>';

        // Pages results
        if (data.pages && data.pages.length > 0) {
            html += `
                <div class="px-5 py-4 border-t border-dashed">
                    <div class="flex items-center">
                        <div class="text-xs uppercase text-slate-500">Pages</div>
                    </div>
                    <div class="flex flex-col gap-1 mt-3.5">
            `;
            data.pages.forEach(page => {
                html += `
                    <a href="${page.url}" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500">
                        <div class="font-medium truncate">${page.name}</div>
                    </a>
                `;
            });
            html += '</div></div>';
        }

        // Users results
        if (data.users && data.users.length > 0) {
            html += `
                <div class="px-5 py-4 border-t border-dashed">
                    <div class="flex items-center">
                        <div class="text-xs uppercase text-slate-500">Users</div>
                    </div>
                    <div class="flex flex-col gap-1 mt-3.5">
            `;
            data.users.forEach(user => {
                html += `
                    <a href="${user.url}" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500">
                        <div class="w-6 h-6 overflow-hidden border-2 rounded-full border-slate-200/70">
                            <img alt="${user.name}" src="${user.avatar}">
                        </div>
                        <div class="font-medium truncate">${user.name}</div>
                        <div class="hidden text-slate-500 sm:block">${user.email}</div>
                    </a>
                `;
            });
            html += '</div></div>';
        }

        // Employees results
        if (data.employees && data.employees.length > 0) {
            html += `
                <div class="px-5 py-4 border-t border-dashed">
                    <div class="flex items-center">
                        <div class="text-xs uppercase text-slate-500">Employees</div>
                    </div>
                    <div class="flex flex-col gap-1 mt-3.5">
            `;
            data.employees.forEach(employee => {
                html += `
                    <a href="${employee.url}" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500">
                        <div class="w-6 h-6 overflow-hidden border-2 rounded-full border-slate-200/70">
                            <img alt="${employee.name}" src="${employee.avatar}">
                        </div>
                        <div class="font-medium truncate">${employee.name}</div>
                        <div class="hidden text-slate-500 sm:block">${employee.department}</div>
                    </a>
                `;
            });
            html += '</div></div>';
        }

        // Departments results
        if (data.departments && data.departments.length > 0) {
            html += `
                <div class="px-5 py-4 border-t border-dashed">
                    <div class="flex items-center">
                        <div class="text-xs uppercase text-slate-500">Departments</div>
                    </div>
                    <div class="flex flex-col gap-1 mt-3.5">
            `;
            data.departments.forEach(department => {
                html += `
                    <a href="${department.url}" class="flex items-center gap-2.5 hover:bg-slate-50/80 border border-transparent hover:border-slate-100 p-1 rounded-md dark:border-transparent dark:hover:bg-darkmode-500">
                        <div class="flex items-center justify-center w-6 h-6 overflow-hidden border rounded-md border-theme-1/10 bg-theme-1/10">
                            <svg class="w-3.5 h-3.5 stroke-[1.3] text-theme-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="font-medium truncate">${department.name}</div>
                        <div class="hidden text-slate-500 sm:block">${department.description || ''}</div>
                    </a>
                `;
            });
            html += '</div></div>';
        }

        // No results
        if (!data.pages?.length && !data.users?.length && !data.employees?.length && !data.departments?.length) {
            html += `
                <div class="px-5 py-8 text-center">
                    <div class="text-slate-400 mb-2">🔍</div>
                    <div class="text-slate-500">No results found for "${data.query}"</div>
                </div>
            `;
        }

        html += '</div>';
        resultsContainer.innerHTML = html;
    }

    function resetSearchResults() {
        // Reset to original content
        const resultsContainer = document.querySelector('#global-search-modal .relative.z-10');
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div>
                    <div class="px-5 py-4">
                        <div class="flex items-center">
                            <div class="text-xs uppercase text-slate-500">Start your search here...</div>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-3.5">
                            <a href="" class="flex items-center gap-x-1.5 border rounded-full px-3 py-0.5 border-slate-300/70 hover:bg-slate-50 dark:hover:bg-darkmode-500">
                                <svg class="w-4 h-4 stroke-[1.3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>Users
                            </a>
                            <a href="" class="flex items-center gap-x-1.5 border rounded-full px-3 py-0.5 border-slate-300/70 hover:bg-slate-50 dark:hover:bg-darkmode-500">
                                <svg class="w-4 h-4 stroke-[1.3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>Departments
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // Add event listeners for opening modal
    searchTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            openSearchModal();
        });
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchModal) {
            closeSearchModal();
        }
    });

    // Open modal with Ctrl+K or Cmd+K
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openSearchModal();
        }
    });

    // Legacy search functionality
    $(".search")
        .find("input")
        .each(function () {
            $(this).on("focus", function () {
                $(".search-result").addClass("show");
            });

            $(this).on("focusout", function () {
                $(".search-result").removeClass("show");
            });
        });
})();
