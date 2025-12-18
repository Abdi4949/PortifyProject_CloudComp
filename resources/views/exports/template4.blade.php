<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $portfolio->title }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0; }
        
        /* --- WEB PREVIEW SETUP --- */
        @if(!$isPdf)
            body { background-color: #f3f4f6; display: flex; justify-content: center; padding: 40px 0; }
            .a4-container { width: 210mm; min-height: 297mm; background-color: white; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin: auto; position: relative; overflow: hidden; }
            .download-btn { position: fixed; bottom: 30px; right: 30px; background-color: #7e22ce; color: white; padding: 15px 25px; border-radius: 50px; text-decoration: none; font-family: sans-serif; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 1000; display: flex; align-items: center; gap: 10px; transition: transform 0.2s; }
            .download-btn:hover { transform: scale(1.05); background-color: #6b21a8; }
        @else
            body { margin: 0; padding: 0; }
            .a4-container { width: 100%; }
        @endif

        /* --- CONTENT STYLING --- */
        .hero { position: relative; height: 300px; overflow: hidden; text-align: center; color: white; background: #000; }
        .hero-img { width: 100%; opacity: 0.6; position: absolute; top: 0; left: 0; z-index: 1; object-fit: cover; height: 100%; }
        .hero-content { position: relative; z-index: 2; top: 50%; transform: translateY(-50%); padding: 0 20px; }
        h1 { font-size: 40px; margin: 0; letter-spacing: 3px; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        h2 { font-weight: 300; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; margin-top: 5px; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
        .skills-bar { padding: 30px 20px; background: #f9f9f9; text-align: center; border-bottom: 1px solid #eee; }
        .skill-item { display: inline-block; padding: 5px 15px; border: 1px solid #333; margin: 5px; font-size: 10px; text-transform: uppercase; background: #fff; }
        .gallery-grid { padding: 20px; }
        .grid-item { width: 48%; float: left; margin-bottom: 30px; page-break-inside: avoid; }
        .grid-item:nth-child(odd) { margin-right: 4%; }
        .grid-img { width: 100%; height: 250px; object-fit: cover; margin-bottom: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .grid-title { font-weight: bold; font-size: 14px; text-transform: uppercase; margin-bottom: 5px; }
        .grid-desc { font-size: 12px; color: #666; line-height: 1.4; }
    </style>
</head>
<body>
    <div class="a4-container">
        <div class="hero">
            @if(!empty($content['profile']['base64']))
                <img src="{{ $content['profile']['base64'] }}" class="hero-img">
            @endif
            <div class="hero-content">
                <h1>{{ $content['profile']['name'] ?? 'CREATIVE' }}</h1>
                <h2>{{ $content['profile']['role'] ?? 'PORTFOLIO' }}</h2>
                <p style="font-size: 12px; margin-top: 15px;">{{ $content['profile']['email'] ?? '' }}</p>
            </div>
        </div>

        <div class="skills-bar">
            @foreach($content['skills'] ?? [] as $skill)
                <span class="skill-item">{{ $skill }}</span>
            @endforeach
        </div>

        <div class="gallery-grid">
            @foreach($content['projects'] ?? [] as $index => $project)
                <div class="grid-item">
                    @if(!empty($project['base64']))
                        <img src="{{ $project['base64'] }}" class="grid-img">
                    @else
                        <div style="height: 250px; background: #eee; width: 100%; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; color: #aaa;">No Image</div>
                    @endif
                    <div class="grid-title">{{ $project['title'] }}</div>
                    <div class="grid-desc">{{ Str::limit($project['description'], 100) }}</div>
                </div>
                
                @if(($index + 1) % 2 == 0)
                    <div style="clear: both;"></div>
                @endif
            @endforeach
            <div style="clear: both;"></div>
        </div>
    </div>

    @if(!$isPdf)
        <a href="{{ route('portfolios.export', $portfolio->id) }}" class="download-btn">
            <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download PDF
        </a>
    @endif
</body>
</html>