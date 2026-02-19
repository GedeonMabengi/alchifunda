@extends('layouts.app')

@section('title', 'Assistant IA Multimodal - ALCHIFUNDA')

@push('styles')
<style>
    :root {
        --font-sans: 'Inter', ui-sans-serif, system-ui;
        --color-brand: #3b82f6;
        --color-secondary: #10b981;
        --color-bg: #0a0a0a;
    }

    body {
        background-color: #0a0a0a;
        color: white;
        overflow-x: hidden;
    }

    .glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: 0 0 40px rgba(59, 130, 246, 0.1);
    }

    /* Forme abstraite de molécule pour le fond */
    .molecule-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
    }

    .molecule-orbit {
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(59, 130, 246, 0.1);
        animation: rotateSlow 40s linear infinite;
    }

    .molecule-dot {
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--color-brand);
        filter: blur(2px);
        opacity: 0.3;
    }

    @keyframes rotateSlow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .float-animation {
        animation: float 6s ease-in-out infinite;
    }

    .pulse-glow {
        animation: pulseGlow 3s ease-in-out infinite alternate;
    }

    @keyframes pulseGlow {
        from { box-shadow: 0 0 20px rgba(59, 130, 246, 0.2); }
        to { box-shadow: 0 0 40px rgba(59, 130, 246, 0.4); }
    }

    /* Badge scientifique */
    .sci-badge {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: #60a5fa;
    }

    /* Message bubbles */
    .message-user {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        border-radius: 24px 24px 4px 24px;
    }

    .message-ai {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px 24px 24px 4px;
        backdrop-filter: blur(10px);
    }

    /* Scrollbar stylisée */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.02);
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(59, 130, 246, 0.3);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(59, 130, 246, 0.5);
    }
</style>
@endpush

@section('content')
<!-- Molécules en arrière-plan -->
<div class="molecule-bg">
    <div class="molecule-orbit" style="width: 800px; height: 800px; top: -200px; right: -200px;"></div>
    <div class="molecule-orbit" style="width: 600px; height: 600px; bottom: -100px; left: -100px; animation-duration: 60s;"></div>
    <div class="molecule-dot" style="top: 20%; left: 10%;"></div>
    <div class="molecule-dot" style="top: 70%; right: 15%;"></div>
    <div class="molecule-dot" style="bottom: 30%; left: 20%;"></div>
    <div class="molecule-dot" style="top: 40%; right: 30%;"></div>
</div>

<div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Badge nouveau système -->
    <div class="flex justify-center mb-8 animate-fade-in">
        <div class="inline-flex items-center gap-2 bg-zinc-900 border border-zinc-800 px-4 py-2 rounded-full text-xs">
            <span class="text-gray-400">Assistant IA Multimodal</span>
            <span class="sci-badge px-2 py-0.5 rounded-full text-white">Gemini Pro 1.5</span>
        </div>
    </div>

    <!-- En-tête avec titre stylisé -->
    <div class="text-center mb-12">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">
            Assistant<span class="text-brand"> IA</span> Multimodal
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">
            Posez vos questions, partagez des images, PDF, audio ou vidéo pour une analyse scientifique approfondie
        </p>
        
        <!-- Statistiques en verre -->
        <div class="flex flex-wrap justify-center gap-4 mt-8">
            <div class="glass px-4 py-2 rounded-full flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-sm">{{ $conversations->total() }} conversations</span>
            </div>
            <div class="glass px-4 py-2 rounded-full flex items-center gap-2">
                <span class="text-brand">🧪</span>
                <span class="text-sm">Analyse moléculaire</span>
            </div>
            <div class="glass px-4 py-2 rounded-full flex items-center gap-2">
                <span class="text-secondary">🔬</span>
                <span class="text-sm">Programme RDC</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Zone de chat principale -->
        <div class="lg:col-span-2">
            <div class="glass-card rounded-3xl overflow-hidden flex flex-col" style="height: 650px;">
                <!-- En-tête du chat avec atomes -->
                <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand to-blue-400 flex items-center justify-center text-xs border border-white/10">IA</div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-400 flex items-center justify-center text-xs border border-white/10">Toi</div>
                        </div>
                        <span class="text-sm text-gray-300">Session active</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">⚛️ Mode scientifique</span>
                    </div>
                </div>

                <!-- Messages -->
                <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4">
                    @if($activeConversation)
                        <!-- Message utilisateur -->
                        <div class="flex justify-end animate-slide-in-right">
                            <div class="max-w-[85%] sm:max-w-3xl">
                                <div class="message-user p-4 shadow-lg">
                                    <p class="text-sm sm:text-base text-white">{{ $activeConversation->user_message }}</p>
                                    @if($activeConversation->has_attachment)
                                        <div class="mt-3">
                                            @if($activeConversation->isImage())
                                                <div class="relative group">
                                                    <img src="{{ $activeConversation->attachmentUrl() }}" class="max-h-32 rounded-lg border border-white/20 cursor-pointer hover:opacity-90 transition" onclick="openImageModal(this.src)">
                                                </div>
                                            @else
                                                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-2 flex items-center gap-2 text-sm">
                                                    <span>📎</span>
                                                    <span class="truncate">{{ $activeConversation->attachment_filename }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right text-xs text-gray-500 mt-1.5">
                                    {{ $activeConversation->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Réponse IA -->
                        <div class="flex justify-start animate-slide-in-left">
                            <div class="max-w-[85%] sm:max-w-3xl">
                                <div class="message-ai p-4">
                                    <div class="prose prose-invert max-w-none text-sm sm:text-base">
                                        {!! nl2br(e($activeConversation->ai_response)) !!}
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1.5">
                                    <span class="text-brand">🔬 Assistant IA</span>
                                    <span>•</span>
                                    <span>{{ $activeConversation->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Message de bienvenue scientifique -->
                        <div class="h-full flex items-center justify-center">
                            <div class="text-center max-w-md mx-auto">
                                <!-- Molécule animée -->
                                <div class="relative w-32 h-32 mx-auto mb-6 float-animation">
                                    <div class="absolute inset-0 bg-brand/20 rounded-full blur-3xl"></div>
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 rounded-full bg-gradient-to-r from-brand to-purple-600 flex items-center justify-center text-2xl">
                                        ⚛️
                                    </div>
                                    <div class="absolute top-0 left-1/2 w-3 h-3 rounded-full bg-blue-400 transform -translate-x-1/2"></div>
                                    <div class="absolute bottom-0 left-1/2 w-3 h-3 rounded-full bg-purple-400 transform -translate-x-1/2"></div>
                                    <div class="absolute top-1/2 left-0 w-3 h-3 rounded-full bg-green-400 transform -translate-y-1/2"></div>
                                    <div class="absolute top-1/2 right-0 w-3 h-3 rounded-full bg-yellow-400 transform -translate-y-1/2"></div>
                                </div>
                                
                                <h2 class="text-2xl font-bold mb-3">Comment puis-je vous aider ?</h2>
                                <p class="text-gray-400 mb-6">
                                    Analyse de composés chimiques, résolution de problèmes, interprétation de spectres...
                                </p>
                                
                                <!-- Types de fichiers supportés -->
                                <div class="flex flex-wrap justify-center gap-2">
                                    <span class="glass px-3 py-1.5 rounded-full text-xs flex items-center gap-1">
                                        <span>🖼️</span> Images
                                    </span>
                                    <span class="glass px-3 py-1.5 rounded-full text-xs flex items-center gap-1">
                                        <span>📄</span> PDF
                                    </span>
                                    <span class="glass px-3 py-1.5 rounded-full text-xs flex items-center gap-1">
                                        <span>🎵</span> Audio
                                    </span>
                                    <span class="glass px-3 py-1.5 rounded-full text-xs flex items-center gap-1">
                                        <span>🎬</span> Vidéo
                                    </span>
                                    <span class="glass px-3 py-1.5 rounded-full text-xs flex items-center gap-1">
                                        <span>🧪</span> Formules
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Zone de saisie -->
                <div class="border-t border-white/5 p-4 glass-card">
                    <!-- Aperçu fichier -->
                    <div id="file-preview" class="hidden mb-3">
                        <div class="flex items-center gap-3 bg-white/5 rounded-xl p-2 border border-white/10 w-fit">
                            <div id="preview-content" class="flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p id="file-name" class="text-sm font-medium text-white truncate"></p>
                                <p id="file-size" class="text-xs text-gray-500"></p>
                            </div>
                            <button onclick="clearFile()" class="p-1.5 hover:bg-white/10 rounded-full transition">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form id="chat-form" onsubmit="sendMessage(event)">
                        <div class="relative flex items-end gap-2">
                            <div class="flex-1 relative">
                                <textarea 
                                    id="message-input" 
                                    rows="1"
                                    class="w-full bg-white/5 border border-white/10 rounded-2xl text-white placeholder-gray-500 focus:border-brand/50 focus:ring-1 focus:ring-brand/50 resize-none pr-12 py-3 text-sm transition"
                                    placeholder="Posez votre question scientifique..."
                                    maxlength="4000"
                                    oninput="autoResize(this)"
                                ></textarea>
                                
                                <label for="file-upload" class="absolute bottom-2 right-2 p-2 text-gray-400 hover:text-brand cursor-pointer rounded-lg hover:bg-white/5 transition" title="Joindre un fichier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </label>
                                <input type="file" id="file-upload" name="file" class="hidden" 
                                       accept="image/*,.pdf,.doc,.docx,.mp3,.mp4,.txt,.wav"
                                       onchange="handleFileSelect(event)">
                            </div>
                            
                            <button type="submit" id="send-btn" 
                                    class="bg-brand hover:bg-blue-600 text-white p-3 rounded-2xl flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed transition shadow-lg hover:shadow-brand/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center justify-between mt-2 px-1">
                            <span id="file-info" class="text-xs text-gray-500 hidden"></span>
                            <span id="char-count" class="text-xs text-gray-500 ml-auto">0/4000</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panneau latéral - Historique scientifique -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="p-4 border-b border-white/5">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Historique des analyses
                    </h3>
                    <span class="text-xs bg-white/5 px-2 py-1 rounded-full">
                        {{ $conversations->total() }}
                    </span>
                </div>
            </div>
            
            <div class="overflow-y-auto max-h-[calc(600px-80px)]">
                @forelse($conversations as $conv)
                    <a href="{{ route('ai.assistant', ['conversation' => $conv->id]) }}" 
                       class="block p-4 border-b border-white/5 hover:bg-white/5 transition group {{ $activeConversation && $activeConversation->id === $conv->id ? 'bg-brand/10 border-l-4 border-l-brand' : '' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm">
                                {{ $conv->has_attachment ? ($conv->isImage() ? '🖼️' : ($conv->isPdf() ? '📕' : '📎')) : '💬' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate group-hover:text-brand transition">
                                    {{ Str::limit($conv->user_message, 30) }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500">
                                        {{ $conv->created_at->diffForHumans() }}
                                    </span>
                                    @if($conv->has_attachment)
                                        <span class="text-xs px-1.5 py-0.5 bg-white/5 rounded-full">📎</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 mx-auto mb-3 bg-white/5 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <p class="text-gray-400 text-sm">Aucune conversation</p>
                        <p class="text-xs text-gray-600 mt-1">Commencez une nouvelle analyse</p>
                    </div>
                @endforelse
            </div>
            
            @if($conversations->hasPages())
                <div class="p-4 border-t border-white/5">
                    {{ $conversations->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Tags scientifiques flottants -->
    <div class="hidden lg:block">
        <div class="fixed left-4 top-1/2 transform -translate-y-1/2 space-y-2">
            <div class="glass px-3 py-2 rounded-full text-xs flex items-center gap-2 animate-pulse">
                <span class="text-brand">⚛️</span> H₂O
            </div>
            <div class="glass px-3 py-2 rounded-full text-xs flex items-center gap-2">
                <span class="text-green-400">🧪</span> C₆H₁₂O₆
            </div>
            <div class="glass px-3 py-2 rounded-full text-xs flex items-center gap-2">
                <span class="text-purple-400">🔬</span> CO₂
            </div>
        </div>
        
        <div class="fixed right-4 top-1/2 transform -translate-y-1/2 space-y-2">
            <div class="glass px-3 py-2 rounded-full text-xs flex items-center gap-2">
                <span class="text-yellow-400">📊</span> pH 7.0
            </div>
            <div class="glass px-3 py-2 rounded-full text-xs flex items-center gap-2">
                <span class="text-blue-400">🌡️</span> 25°C
            </div>
            <div class="glass px-3 py-2 rounded-full text-xs flex items-center gap-2">
                <span class="text-red-400">⚡</span> 1.23V
            </div>
        </div>
    </div>
</div>

<!-- Modal pour images -->
<div id="imageModal" class="fixed inset-0 bg-black/90 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" class="max-w-full max-h-[90vh] rounded-2xl border border-white/10" alt="">
        <button class="absolute top-4 right-4 text-white bg-black/50 rounded-full p-2 hover:bg-black/75 transition border border-white/20" onclick="closeImageModal()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    let selectedFile = null;
    let isProcessing = false;

    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
        updateCharCount();
    }

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        if (file.size > 20 * 1024 * 1024) {
            alert('Fichier trop volumineux (max 20MB)');
            e.target.value = '';
            return;
        }
        
        selectedFile = file;
        updatePreview();
    }

    function updatePreview() {
        const preview = document.getElementById('file-preview');
        const content = document.getElementById('preview-content');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        
        if (!selectedFile) {
            preview.classList.add('hidden');
            return;
        }

        preview.classList.remove('hidden');
        
        const name = selectedFile.name.length > 30 
            ? selectedFile.name.substring(0, 27) + '...' 
            : selectedFile.name;
        fileName.textContent = name;
        
        const size = selectedFile.size / 1024 / 1024;
        fileSize.textContent = size.toFixed(2) + ' MB';

        if (selectedFile.type.startsWith('image/')) {
            const url = URL.createObjectURL(selectedFile);
            content.innerHTML = `<img src="${url}" class="h-12 w-12 object-cover rounded-lg border border-white/10" alt="">`;
        } else {
            let icon = '📄';
            if (selectedFile.type.includes('pdf')) icon = '📕';
            else if (selectedFile.type.includes('audio')) icon = '🎵';
            else if (selectedFile.type.includes('video')) icon = '🎬';
            content.innerHTML = `<span class="text-2xl">${icon}</span>`;
        }
    }

    function clearFile() {
        selectedFile = null;
        document.getElementById('file-upload').value = '';
        document.getElementById('file-preview').classList.add('hidden');
    }

    function openImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    async function sendMessage(e) {
        e.preventDefault();
        
        if (isProcessing) return;
        
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        const btn = document.getElementById('send-btn');
        const messages = document.getElementById('chat-messages');
        
        if (!message && !selectedFile) {
            alert('Veuillez entrer un message ou joindre un fichier');
            return;
        }
        
        isProcessing = true;
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        // Afficher le message utilisateur
        let userHtml = `<div class="flex justify-end mb-4"><div class="max-w-[85%]"><div class="message-user p-4">`;
        
        if (message) {
            userHtml += `<p class="text-sm text-white">${escapeHtml(message)}</p>`;
        }
        
        if (selectedFile) {
            userHtml += `<div class="mt-3">`;
            if (selectedFile.type.startsWith('image/')) {
                const url = URL.createObjectURL(selectedFile);
                userHtml += `<img src="${url}" class="max-h-24 rounded-lg border border-white/20" alt="">`;
            } else {
                userHtml += `<div class="bg-white/10 rounded-lg p-2 text-sm flex items-center gap-2">`;
                userHtml += `<span>📎</span>`;
                userHtml += `<span class="truncate">${escapeHtml(selectedFile.name)}</span>`;
                userHtml += `</div>`;
            }
            userHtml += `</div>`;
        }
        
        userHtml += `</div></div></div>`;
        
        messages.insertAdjacentHTML('beforeend', userHtml);
        
        input.value = '';
        autoResize(input);
        messages.scrollTop = messages.scrollHeight;

        const formData = new FormData();
        formData.append('message', message);
        if (selectedFile) {
            formData.append('file', selectedFile);
        }

        try {
            const res = await fetch('{{ route("ai.ask") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await res.json();
            
            if (data.success) {
                messages.insertAdjacentHTML('beforeend', `
                    <div class="flex justify-start mb-4">
                        <div class="max-w-[85%]">
                            <div class="message-ai p-4">
                                <div class="prose prose-invert max-w-none text-sm">
                                    ${formatText(data.response)}
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-1.5">
                                <span class="text-brand">🔬 Assistant IA</span>
                                <span>•</span>
                                <span>${data.processing_time ? `Analyse en ${data.processing_time}ms` : ''}</span>
                            </div>
                        </div>
                    </div>
                `);
                
                if (data.conversation_id) {
                    const url = new URL(window.location);
                    url.searchParams.set('conversation', data.conversation_id);
                    window.history.pushState({}, '', url);
                }
            } else {
                throw new Error(data.message || 'Erreur lors de l\'analyse');
            }
        } catch (err) {
            messages.insertAdjacentHTML('beforeend', `
                <div class="flex justify-center mb-4">
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl p-3 text-sm">
                        ⚠️ ${escapeHtml(err.message)}
                    </div>
                </div>
            `);
        } finally {
            isProcessing = false;
            btn.disabled = false;
            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>';
            clearFile();
            messages.scrollTop = messages.scrollHeight;
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatText(text) {
        if (!text) return '';
        return escapeHtml(text)
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong class="text-brand">$1</strong>')
            .replace(/\*(.*?)\*/g, '<em class="text-gray-300">$1</em>')
            .replace(/`(.*?)`/g, '<code class="bg-white/5 px-1 rounded border border-white/10">$1</code>');
    }

    function updateCharCount() {
        const len = document.getElementById('message-input').value.length;
        document.getElementById('char-count').textContent = `${len}/4000`;
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('message-input');
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
        
        updateCharCount();
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    });
</script>
@endpush
@endsection