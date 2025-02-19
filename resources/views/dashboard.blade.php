<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dashboard - LynkCo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/9.6.0/firebase-app-compat.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/9.6.0/firebase-firestore-compat.js"></script>
    @vite(['resources/js/firebase.js', 'resources/js/logout.js'])
    <style>
        body {
            font-family: "Noto Sans", sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #2f3136;
        }
        ::-webkit-scrollbar-thumb {
            background: #202225;
            border-radius: 4px;
        }
        .no-select {
            user-select: none;
        }
    </style>

</head>
<body class="bg-gray-100">
    <main class="flex h-screen text-white bg-neutral-800 overflow-hidden">
        <aside class="flex h-full">
            <nav class="flex flex-col gap-2 items-center px-0 py-4 bg-neutral-800 w-[72px] max-sm:w-[72px] no-select">
                <button class="flex relative justify-center items-center w-12 h-12 rounded-full cursor-pointer bg-zinc-800 hover:bg-zinc-700 transition-colors">
                    <i class="ti ti-users text-xl"></i>
                    <div class="absolute left-0 w-1 h-10 rounded-r-lg bg-white"></div>
                </button>

                <div class="mx-0 my-2 w-8 h-0.5 bg-zinc-600 bg-opacity-50"></div>

                <button class="flex relative justify-center items-center w-12 h-12 rounded-full cursor-pointer bg-zinc-800 hover:bg-zinc-700 transition-colors">
                    <i class="ti ti-messages text-xl"></i>
                    <span class="notification-badge absolute -right-1 -bottom-1 px-1.5 py-0.5 text-xs bg-red-500 rounded-full min-w-[20px] text-center" data-type="messages">0</span>
                </button>

                <button class="flex relative justify-center items-center w-12 h-12 rounded-full cursor-pointer bg-zinc-800 hover:bg-zinc-700 transition-colors">
                    <i class="ti ti-bell text-xl"></i>
                    <span class="notification-badge absolute -right-1 -bottom-1 px-1.5 py-0.5 text-xs bg-red-500 rounded-full min-w-[20px] text-center" data-type="notifications">0</span>
                </button>
            </nav>

            <aside class="flex flex-col w-60 bg-zinc-800 max-sm:hidden border-r border-zinc-700">
                <div class="p-3 text-sm">
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Find or start a conversation" 
                            class="w-full px-2 py-1.5 bg-zinc-900 rounded text-zinc-300 outline-none focus:ring-2 focus:ring-zinc-600"
                        />
                        <i class="ti ti-search absolute right-2 top-1/2 -translate-y-1/2 text-zinc-400"></i>
                    </div>
                </div>

                <nav class="flex-1 p-2 overflow-y-auto">
                    <button class="flex gap-3 items-center p-2 rounded cursor-pointer text-zinc-300 w-full hover:bg-zinc-700 transition-colors">
                        <i class="ti ti-users"></i>
                        <span>Friends</span>
                    </button>

                    <div class="flex justify-between px-2 pt-6 pb-2 text-xs font-semibold text-zinc-400">
                        <span>DIRECT MESSAGES</span>
                        <button aria-label="Add Direct Message" class="hover:text-zinc-200">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>

                    <div id="dmList" class="flex flex-col gap-0.5">
                        <!-- DMs will be dynamically inserted here -->
                    </div>
                </nav>

                <footer class="flex items-center px-2 py-2 bg-zinc-900 h-[52px] gap-2">
                    <div class="w-8 h-8 rounded-full bg-zinc-700 flex items-center justify-center">
                        <i class="ti ti-user text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-zinc-400">#{{ Auth::user()->id }}</div>
                    </div>
                    <div class="flex gap-1">
                        <button aria-label="Microphone settings" class="p-2 text-zinc-400 hover:text-zinc-200">
                            <i class="ti ti-microphone"></i>
                        </button>
                        <button aria-label="Headphone settings" class="p-2 text-zinc-400 hover:text-zinc-200">
                            <i class="ti ti-headphones"></i>
                        </button>
                        <button aria-label="User settings" class="p-2 text-zinc-400 hover:text-zinc-200">
                            <i class="ti ti-settings"></i>
                        </button>
                    </div>
                </footer>
            </aside>
        </aside>

        <section class="flex flex-col flex-1 bg-zinc-700" aria-label="Main content">
            <header class="p-3 bg-zinc-800 border-b border-zinc-700">
                <div class="flex gap-2 items-center text-base font-semibold">
                    <i class="ti ti-users" aria-hidden="true"></i>
                    <span>Friends</span>
                    <nav class="flex flex-wrap gap-4 items-center ml-8" aria-label="Friends filters">
                        <button 
                            data-status="online" 
                            class="px-3 py-1 text-sm rounded bg-zinc-600 hover:bg-zinc-500 focus:ring-2 focus:ring-white transition-all"
                        >
                            Online - 0
                        </button>
                        <button class="px-3 py-1 text-sm rounded hover:bg-zinc-700 focus:ring-2 focus:ring-white transition-all">All</button>
                        <button class="px-3 py-1 text-sm rounded hover:bg-zinc-700 focus:ring-2 focus:ring-white transition-all">Pending</button>
                        <button class="px-3 py-1 text-sm rounded hover:bg-zinc-700 focus:ring-2 focus:ring-white transition-all">Blocked</button>
                        <button class="px-3 py-1 text-sm bg-green-600 rounded hover:bg-green-500 focus:ring-2 focus:ring-white transition-all">Add Friend</button>
                    </nav>
                    <form id="logoutForm" class="inline ml-auto">
                        <button 
                            type="submit" 
                            id="logoutButton"
                            class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md transition-all duration-200 ease-in-out focus:ring-2 focus:ring-white disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                        >
                            <span>Logout</span>
                            <svg class="hidden animate-spin h-4 w-4" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <div id="mainContent" class="flex flex-1 justify-center items-center text-center bg-zinc-800 p-4">
                <div class="flex flex-col gap-6 items-center">
                    <img 
                        src="/api/placeholder/400/200" 
                        alt="Wumpus character illustration showing no friends are currently online" 
                        class="rounded-lg"
                        width="400"
                        height="200"
                    />
                    <p class="text-zinc-400 text-lg">No one's around to play with Wumpus.</p>
                </div>
            </div>
        </section>

        <div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-zinc-800 p-6 rounded-lg shadow-lg">
                <div class="flex items-center gap-3">
                    <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                    <span class="text-white font-medium">Logging out...</span>
                </div>
            </div>
        </div>
        <div id="errorMessage" class="hidden fixed top-4 right-4 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 fade-in">
            <div class="flex items-center gap-2">
                <i class="ti ti-alert-circle"></i>
                <span>Failed to logout. Please try again.</span>
            </div>
        </div>
    </main>
</body>
</html>