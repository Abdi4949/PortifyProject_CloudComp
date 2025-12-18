<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $portfolio->title }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: sans-serif; }
        
        /* CSS KHUSUS PDF (LAYOUT TABEL) */
        @if(isset($isPdf) && $isPdf)
            @page { margin: 0px; }
            body { margin: 0px; background: #fff; color: #333; }
            
            .pdf-container { padding: 40px; }
            
            /* Header */
            .header-table { width: 100%; border-bottom: 1px solid #eee; margin-bottom: 30px; background: #f9fafb; padding: 40px 20px; text-align: center; }
            .avatar-img { width: 100px; height: 100px; border-radius: 50%; border: 3px solid #ddd; object-fit: cover; }
            
            /* Project Grid (Menggunakan Tabel HTML agar Rapi 2 Kolom) */
            .projects-table { width: 100%; border-spacing: 20px; border-collapse: separate; table-layout: fixed; }
            .project-cell { 
                width: 45%; 
                vertical-align: top; 
                border: 1px solid #ddd; 
                background: #fff;
                margin-bottom: 20px;
                overflow: hidden;
            }
            .project-img { width: 100%; height: 200px; object-fit: cover; display: block; border-bottom: 1px solid #eee; }
            .project-info { padding: 15px; }
            .project-title { font-size: 16px; font-weight: bold; margin: 0 0 5px 0; }
            .project-desc { font-size: 12px; color: #666; margin: 0; }
        @endif

        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased relative">

    @if(!isset($isPdf) || !$isPdf) 
    <div class="fixed bottom-6 right-6 z-50 no-print">
        <form action="{{ route('portfolios.export', $portfolio->id) }}" method="GET">
            <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-full font-bold shadow-xl hover:bg-gray-800 transition flex items-center gap-2 transform hover:scale-105 border border-gray-700">
                Export PDF
            </button>
        </form>
    </div>
    @endif

    @if(isset($isPdf) && $isPdf)
        
        <div class="header-table">
            @if(!empty($content['profile']['base64']))
                <img src="{{ $content['profile']['base64'] }}" class="avatar-img"><br>
            @endif
            <h1 style="font-size: 28px; margin: 10px 0;">{{ $content['profile']['name'] ?? 'Your Name' }}</h1>
            <p style="color: #666; font-size: 12px;">{{ $content['profile']['bio'] ?? '' }}</p>
            <div style="font-size: 10px; color: #444; margin-top: 10px;">
                {{ $content['profile']['email'] ?? '' }} 
                @if(!empty($content['profile']['linkedin'])) | LinkedIn Available @endif
            </div>
        </div>

        <div class="pdf-container">
            <h2 style="text-align: center; text-transform: uppercase; border-bottom: 2px solid #333; display: inline-block; margin-bottom: 20px;">Selected Work</h2>
            
            <table class="projects-table">
                @if(!empty($content['projects']))
                    @php $chunks = array_chunk($content['projects'], 2); @endphp
                    @foreach($chunks as $row)
                    <tr>
                        @foreach($row as $project)
                        <td class="project-cell">
                            @if(!empty($project['base64']))
                                <img src="{{ $project['base64'] }}" class="project-img">
                            @else
                                <div style="height: 200px; background: #eee; text-align: center; line-height: 200px; color: #aaa;">No Image</div>
                            @endif
                            <div class="project-info">
                                <h3 class="project-title">{{ $project['title'] }}</h3>
                                <p class="project-desc">{{ $project['description'] }}</p>
                            </div>
                        </td>
                        @endforeach
                        @if(count($row) < 2) <td width="50%"></td> @endif
                    </tr>
                    @endforeach
                @endif
            </table>
        </div>

    @else
        <header class="bg-white border-b border-gray-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                @if(!empty($content['profile']['image']))
                    <img src="{{ '/storage/' . str_replace(['public/', 'storage/'], '', $content['profile']['image']) }}" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-white shadow-lg mb-6">
                @endif
                <h1 class="text-5xl font-extrabold text-gray-900 mb-6">{{ $content['profile']['name'] ?? 'Your Name' }}</h1>
                <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10">{{ $content['profile']['bio'] ?? '' }}</p>
            </div>
        </header>

        <section class="py-20 max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-16">Selected Work</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @if(!empty($content['projects']))
                    @foreach($content['projects'] as $project)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="h-64 bg-gray-100">
                            @if(!empty($project['image']))
                                <img src="{{ '/storage/' . str_replace(['public/', 'storage/'], '', $project['image']) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold mb-2">{{ $project['title'] }}</h3>
                            <p class="text-gray-500 line-clamp-3">{{ $project['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </section>
    @endif

</body>
</html>