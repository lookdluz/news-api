<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias de Tecnologia — Projeto de Portfólio</title>

    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        async function loadNews() {
            const container = document.getElementById('news');
            container.innerHTML = `<p class="text-gray-500 animate-pulse">Carregando notícias...</p>`;

            try {
                const res = await fetch('{{ url('/api/news') }}');
                const json = await res.json();
                const news = json.data || [];

                if (news.length === 0) {
                    container.innerHTML = `<p class="text-gray-500">Nenhuma notícia encontrada.</p>`;
                    return;
                }

                container.innerHTML = news.map(n => `
                    <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
                        ${n.url_to_image ? `<img src="${n.url_to_image}" class="rounded-xl mb-3 w-full h-48 object-cover" alt="Imagem da notícia">` : ''}
                        <h2 class="text-lg font-semibold text-gray-800 mb-1">${n.title}</h2>
                        <p class="text-sm text-gray-600 mb-2">${n.description ?? ''}</p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>${n.source ?? 'Fonte desconhecida'}</span>
                            <span>${new Date(n.published_at).toLocaleDateString('pt-BR')}</span>
                        </div>
                        <a href="${n.url}" target="_blank" class="inline-block mt-3 text-blue-600 text-sm hover:underline">Ler matéria completa →</a>
                    </div>
                `).join('');
            } catch (error) {
                container.innerHTML = `<p class="text-red-500">Erro ao carregar notícias 😕</p>`;
                console.error(error);
            }
        }

        document.addEventListener('DOMContentLoaded', loadNews);
    </script>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                📰 <span>API de Notícias — <span class="text-blue-600">Portfólio</span></span>
            </h1>
            <a href="https://newsapi.org" target="_blank" class="text-sm text-blue-600 hover:underline">Powered by NewsAPI.org</a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8">
        <div id="news" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <p class="text-gray-500">Carregando...</p>
        </div>
    </main>

    <footer class="text-center py-6 text-gray-500 text-sm">
        Desenvolvido com ❤️ por <strong>Lucas Luz</strong> — Laravel 12 · PHP 8.3
    </footer>
</body>
</html>

