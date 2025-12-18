<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $portfolio->title }}</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; color: #333; }
        
        /* --- WEB PREVIEW SETUP --- */
        @if(!$isPdf)
            body { background-color: #f3f4f6; display: flex; justify-content: center; padding: 40px 0; }
            .a4-container { width: 210mm; min-height: 297mm; background-color: white; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin: auto; position: relative; }
            .download-btn { position: fixed; bottom: 30px; right: 30px; background-color: #7e22ce; color: white; padding: 15px 25px; border-radius: 50px; text-decoration: none; font-family: sans-serif; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 1000; display: flex; align-items: center; gap: 10px; transition: transform 0.2s; }
            .download-btn:hover { transform: scale(1.05); background-color: #6b21a8; }
        @else
            body { margin: 0; padding: 0; }
            .a4-container { width: 100%; }
        @endif

        /* --- CONTENT STYLING --- */
        .header { background-color: #2563eb; color: white; padding: 40px 20px; text-align: center; }
        .profile-img { width: 120px; height: 120px; border-radius: 50%; border: 4px solid white; object-fit: cover; margin-bottom: 15px; }
        h1 { margin: 0; font-size: 28px; text-transform: uppercase; letter-spacing: 1px; }
        h2 { font-weight: normal; font-size: 16px; opacity: 0.9; margin: 5px 0 0; }
        .contact-info { margin-top: 10px; font-size: 12px; }
        .content { padding: 40px; }
        .section { margin-bottom: 30px; }
        .section-title { color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 5px; margin-bottom: 15px; text-transform: uppercase; font-size: 14px; font-weight: bold; letter-spacing: 1px; }
        .skills-container { margin-top: 10px; }
        .skill-badge { background: #eff6ff; color: #1e40af; padding: 5px 12px; border-radius: 20px; font-size: 11px; margin-right: 5px; display: inline-block; margin-bottom: 5px; border: 1px solid #bfdbfe; }
        .project-item { margin-bottom: 25px; page-break-inside: avoid; border: 1px solid #eee; padding: 15px; border-radius: 8px; }
        .project-img { width: 100%; height: 180px; object-fit: cover; border-radius: 4px; margin-bottom: 10px; border: 1px solid #ddd; }
        .project-title { font-weight: bold; font-size: 16px; color: #111; }
        .project-link { color: #2563eb; font-size: 12px; text-decoration: none; }
        .project-desc { font-size: 13px; color: #555; line-height: 1.5; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="a4-container">
        <div class="header">
            @if(!empty($content['profile']['base64']))
                <img src="{{ $content['profile']['base64'] }}" class="profile-img">
            @endif
            <h1>{{ $content['profile']['name'] ?? 'Your Name' }}</h1>
            <h2>{{ $content['profile']['role'] ?? 'Your Role' }}</h2>
            <div class="contact-info">
                {{ $content['profile']['email'] ?? '' }} 
                @if(!empty($content['profile']['linkedin'])) | LinkedIn: {{ basename($content['profile']['linkedin']) }} @endif
            </div>
        </div>

        <div class="content">
            <div class="section">
                <div class="section-title">About Me</div>
                <p style="line-height: 1.6; font-size: 14px;">{{ $content['profile']['bio'] ?? 'No bio description provided.' }}</p>
            </div>

            <div class="section">
                <div class="section-title">Skills</div>
                <div class="skills-container">
                    @foreach($content['skills'] ?? [] as $skill)
                        <span class="skill-badge">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>

            <div class="section">
                <div class="section-title">Selected Projects</div>
                @foreach($content['projects'] ?? [] as $project)
                    <div class="project-item">
                        @if(!empty($project['base64']))
                            <img src="{{ $project['base64'] }}" class="project-img">
                        @endif
                        <div class="project-title">{{ $project['title'] }}</div>
                        <a href="{{ $project['link'] }}" class="project-link">{{ $project['link'] }}</a>
                        <p class="project-desc">{{ $project['description'] }}</p>
                    </div>
                @endforeach
            </div>
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