<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $portfolio->title }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 0; color: #333; }
        
        /* --- WEB PREVIEW SETUP --- */
        @if(!$isPdf)
            body { background-color: #f3f4f6; display: flex; justify-content: center; padding: 40px 0; }
            .a4-container { width: 210mm; min-height: 297mm; background-color: white; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin: auto; position: relative; display: flex; }
            .download-btn { position: fixed; bottom: 30px; right: 30px; background-color: #7e22ce; color: white; padding: 15px 25px; border-radius: 50px; text-decoration: none; font-family: sans-serif; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 1000; display: flex; align-items: center; gap: 10px; transition: transform 0.2s; }
            .download-btn:hover { transform: scale(1.05); background-color: #6b21a8; }
        @else
            body { margin: 0; padding: 0; }
            .a4-container { width: 100%; }
        @endif

        /* --- CONTENT STYLING --- */
        table { width: 100%; border-collapse: collapse; height: 100%; }
        td { vertical-align: top; }
        .sidebar { background-color: #f3f4f6; width: 30%; padding: 30px 20px; border-right: 1px solid #e5e7eb; min-height: 100vh; }
        .main-content { width: 70%; padding: 40px 30px; background-color: white; }
        .profile-img { width: 100px; height: 100px; border-radius: 8px; object-fit: cover; margin-bottom: 20px; }
        .sidebar-title { font-size: 12px; font-weight: bold; text-transform: uppercase; margin-bottom: 10px; color: #4b5563; border-bottom: 1px solid #d1d5db; padding-bottom: 5px; margin-top: 30px; }
        .sidebar-text { font-size: 12px; margin-bottom: 8px; word-wrap: break-word; }
        .main-name { font-size: 32px; font-weight: bold; text-transform: uppercase; color: #111; line-height: 1; }
        .main-role { font-size: 18px; color: #666; margin-top: 5px; margin-bottom: 30px; letter-spacing: 2px; }
        .section-head { font-size: 16px; font-weight: bold; border-bottom: 2px solid #111; padding-bottom: 5px; margin-bottom: 20px; margin-top: 30px; text-transform: uppercase; }
        .proj-item { margin-bottom: 25px; page-break-inside: avoid; }
        .proj-img { width: 120px; height: 80px; object-fit: cover; float: left; margin-right: 15px; border: 1px solid #eee; }
        .proj-details { overflow: hidden; }
        .proj-title { font-weight: bold; font-size: 15px; }
        .proj-desc { font-size: 13px; color: #555; margin-top: 5px; line-height: 1.4; }
    </style>
</head>
<body>
    <div class="a4-container">
        <table>
            <tr>
                <td class="sidebar">
                    @if(!empty($content['profile']['base64']))
                        <img src="{{ $content['profile']['base64'] }}" class="profile-img">
                    @endif

                    <div class="sidebar-title">Contact</div>
                    <div class="sidebar-text">✉️ {{ $content['profile']['email'] ?? '-' }}</div>
                    @if(!empty($content['profile']['linkedin']))
                        <div class="sidebar-text">🔗 {{ basename($content['profile']['linkedin']) }}</div>
                    @endif

                    <div class="sidebar-title">Expertise</div>
                    @foreach($content['skills'] ?? [] as $skill)
                        <div style="background: white; padding: 4px 8px; margin-bottom: 5px; font-size: 11px; border: 1px solid #ddd; border-radius: 4px;">{{ $skill }}</div>
                    @endforeach
                </td>

                <td class="main-content">
                    <div class="main-name">{{ $content['profile']['name'] ?? 'NAME' }}</div>
                    <div class="main-role">{{ $content['profile']['role'] ?? 'ROLE' }}</div>

                    <div class="section-head">Profile</div>
                    <p style="font-size: 14px; line-height: 1.6; color: #444;">
                        {{ $content['profile']['bio'] ?? '' }}
                    </p>

                    <div class="section-head">Portfolio Highlights</div>
                    
                    @foreach($content['projects'] ?? [] as $project)
                        <div class="proj-item">
                            @if(!empty($project['base64']))
                                <img src="{{ $project['base64'] }}" class="proj-img">
                            @endif
                            <div class="proj-details">
                                <div class="proj-title">{{ $project['title'] }}</div>
                                <small style="color:#2563eb;">{{ $project['link'] }}</small>
                                <div class="proj-desc">{{ $project['description'] }}</div>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>

    @if(!$isPdf)
        <a href="{{ route('portfolios.export', $portfolio->id) }}" class="download-btn">
            <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download PDF
        </a>
    @endif
</body>
</html>