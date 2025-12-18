<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $portfolio->title }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; margin: 0; padding: 0; color: #e2e8f0; }
        
        /* --- WEB PREVIEW SETUP --- */
        @if(!$isPdf)
            body { background-color: #f3f4f6; display: flex; justify-content: center; padding: 40px 0; }
            .a4-container { width: 210mm; min-height: 297mm; background-color: #1a202c; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin: auto; position: relative; }
            .download-btn { position: fixed; bottom: 30px; right: 30px; background-color: #7e22ce; color: white; padding: 15px 25px; border-radius: 50px; text-decoration: none; font-family: sans-serif; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 1000; display: flex; align-items: center; gap: 10px; transition: transform 0.2s; }
            .download-btn:hover { transform: scale(1.05); background-color: #6b21a8; }
        @else
            body { padding: 40px; background-color: #1a202c; }
            .a4-container { width: 100%; }
        @endif

        /* --- CONTENT STYLING --- */
        .header { border-bottom: 2px solid #ed64a6; padding-bottom: 20px; margin-bottom: 30px; display: table; width: 100%; }
        .header-text { display: table-cell; vertical-align: middle; }
        .name { font-size: 36px; font-weight: bold; color: #ed64a6; text-transform: lowercase; }
        .role { font-size: 18px; color: #a0aec0; margin-top: 5px; }
        .code-block { background: #2d3748; padding: 15px; border-radius: 6px; font-size: 12px; font-family: monospace; color: #48bb78; margin-bottom: 30px; border-left: 4px solid #48bb78; }
        .section-title { font-size: 20px; color: #fff; border-bottom: 1px dashed #718096; padding-bottom: 10px; margin-bottom: 20px; margin-top: 40px; }
        .grid-container { width: 100%; }
        .grid-item { width: 48%; float: left; margin-bottom: 20px; margin-right: 2%; background: #2d3748; padding: 15px; box-sizing: border-box; border-radius: 8px; page-break-inside: avoid; }
        .grid-item:nth-child(even) { margin-right: 0; }
        .proj-img { width: 100%; height: 120px; object-fit: cover; margin-bottom: 10px; border-radius: 4px; opacity: 0.8; }
        .skill-tag { background: #ed64a6; color: white; padding: 3px 8px; font-size: 10px; border-radius: 4px; margin-right: 5px; display: inline-block; }
    </style>
</head>
<body>
    <div class="a4-container">
        <div class="header">
            <div class="header-text">
                <div class="name">&lt;{{ str_replace(' ', '_', strtolower($content['profile']['name'] ?? 'dev')) }} /&gt;</div>
                <div class="role">// {{ $content['profile']['role'] ?? 'Full Stack Developer' }}</div>
            </div>
        </div>

        <div class="code-block">
            const profile = {<br>
            &nbsp;&nbsp;bio: "{{ Str::limit($content['profile']['bio'] ?? 'Loading...', 100) }}",<br>
            &nbsp;&nbsp;email: "{{ $content['profile']['email'] ?? '' }}",<br>
            &nbsp;&nbsp;status: "Ready to Hire"<br>
            };
        </div>

        <div class="section-title">Stack & Skills</div>
        <div style="margin-bottom: 20px;">
            @foreach($content['skills'] ?? [] as $skill)
                <span class="skill-tag">{{ $skill }}</span>
            @endforeach
        </div>

        <div class="section-title">Deployed Projects</div>
        <div class="grid-container">
            @foreach($content['projects'] ?? [] as $index => $project)
                <div class="grid-item">
                    @if(!empty($project['base64']))
                        <img src="{{ $project['base64'] }}" class="proj-img">
                    @endif
                    <div style="font-weight: bold; color: #fff; margin-bottom: 5px;">{{ $project['title'] }}</div>
                    <div style="font-size: 11px; color: #a0aec0; margin-bottom: 8px;">{{ Str::limit($project['description'], 60) }}</div>
                    <a href="{{ $project['link'] }}" style="color: #ed64a6; font-size: 11px; text-decoration: none;">View Source -></a>
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