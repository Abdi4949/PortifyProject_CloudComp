<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $portfolio->title }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; line-height: 1.4; margin: 0; padding: 0; }

        /* --- WEB PREVIEW SETUP --- */
        @if(!$isPdf)
            body { background-color: #f3f4f6; display: flex; justify-content: center; padding: 40px 0; }
            .a4-container { width: 210mm; min-height: 297mm; background-color: white; padding: 50px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin: auto; position: relative; }
            .download-btn { position: fixed; bottom: 30px; right: 30px; background-color: #7e22ce; color: white; padding: 15px 25px; border-radius: 50px; text-decoration: none; font-family: sans-serif; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 1000; display: flex; align-items: center; gap: 10px; transition: transform 0.2s; }
            .download-btn:hover { transform: scale(1.05); background-color: #6b21a8; }
        @else
            body { padding: 50px; }
            .a4-container { width: 100%; }
        @endif

        /* --- CONTENT STYLING --- */
        .header { border-bottom: 4px solid #000; padding-bottom: 20px; margin-bottom: 40px; }
        .name { font-size: 42px; font-weight: bold; letter-spacing: -1px; margin: 0; }
        .role { font-style: italic; font-size: 18px; margin-top: 5px; }
        .contact { font-family: sans-serif; font-size: 10px; margin-top: 15px; color: #555; }
        .section-label { font-family: sans-serif; font-weight: bold; font-size: 10px; text-transform: uppercase; margin-bottom: 15px; color: #666; margin-top: 40px; letter-spacing: 1px; }
        .bio-text { font-size: 16px; text-align: justify; margin-bottom: 30px; line-height: 1.6; }
        .project-row { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; page-break-inside: avoid; }
        .project-title { font-size: 20px; font-weight: bold; margin-bottom: 5px; }
        .project-link { font-family: sans-serif; font-size: 10px; color: #666; text-decoration: none; }
        .project-desc { margin-top: 10px; font-size: 14px; color: #333; }
        .project-img { width: 100%; height: 200px; object-fit: cover; margin-top: 15px; filter: grayscale(100%); border: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="a4-container">
        <div class="header">
            <div class="name">{{ $content['profile']['name'] ?? 'John Doe' }}</div>
            <div class="role">{{ $content['profile']['role'] ?? 'Writer & Thinker' }}</div>
            <div class="contact">
                {{ $content['profile']['email'] ?? '' }} 
                @if(!empty($content['profile']['linkedin'])) • {{ $content['profile']['linkedin'] }} @endif
            </div>
        </div>

        <div class="section-label">01. BIOGRAPHY</div>
        <div class="bio-text">
            {{ $content['profile']['bio'] ?? '' }}
        </div>

        <div class="section-label">02. SELECTED WORKS</div>
        @foreach($content['projects'] ?? [] as $project)
            <div class="project-row">
                <div class="project-title">{{ $project['title'] }}</div>
                <a href="{{ $project['link'] }}" class="project-link">🔗 {{ $project['link'] }}</a>
                @if(!empty($project['base64']))
                    <img src="{{ $project['base64'] }}" class="project-img">
                @endif
                <div class="project-desc">{{ $project['description'] }}</div>
            </div>
        @endforeach

        <div class="section-label">03. SKILLS</div>
        <div style="font-family: sans-serif; font-size: 12px; line-height: 1.8;">
            {{ implode('  /  ', $content['skills'] ?? []) }}
        </div>
    </div>

    @if(!$isPdf)
        <a href="{{ route('portfolios.exportPdf', $portfolio->id) }}" class="download-btn">
            <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download PDF
        </a>
    @endif
</body>
</html>