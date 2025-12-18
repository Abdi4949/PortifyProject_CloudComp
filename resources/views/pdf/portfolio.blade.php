<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            padding: 30px;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            margin: -30px -30px 30px -30px;
        }
        
        .header h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }
        
        .header .profession {
            font-size: 18px;
            opacity: 0.9;
        }
        
        /* Contact Bar */
        .contact-bar {
            background: #f7fafc;
            padding: 15px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        
        .contact-bar .contact-item {
            display: inline-block;
            margin-right: 20px;
            font-size: 11px;
        }
        
        /* Section */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #667eea;
        }
        
        .section-content {
            padding-left: 5px;
        }
        
        /* Skills */
        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .skill-tag {
            background: #edf2f7;
            color: #2d3748;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 11px;
            display: inline-block;
        }
        
        /* Projects */
        .project-item {
            margin-bottom: 15px;
            padding-left: 15px;
            border-left: 3px solid #667eea;
        }
        
        .project-title {
            font-size: 14px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 4px;
        }
        
        .project-url {
            color: #667eea;
            font-size: 10px;
            margin-bottom: 6px;
        }
        
        .project-description {
            font-size: 11px;
            color: #4a5568;
        }
        
        /* Experience */
        .experience-item {
            margin-bottom: 18px;
        }
        
        .experience-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        
        .experience-position {
            font-size: 14px;
            font-weight: bold;
            color: #2d3748;
        }
        
        .experience-period {
            font-size: 11px;
            color: #718096;
        }
        
        .experience-company {
            font-size: 12px;
            color: #4a5568;
            margin-bottom: 6px;
            font-weight: 600;
        }
        
        .experience-description {
            font-size: 11px;
            color: #4a5568;
        }
        
        /* Education */
        .education-item {
            margin-bottom: 12px;
        }
        
        .education-degree {
            font-size: 13px;
            font-weight: bold;
            color: #2d3748;
        }
        
        .education-school {
            font-size: 12px;
            color: #4a5568;
        }
        
        .education-period {
            font-size: 10px;
            color: #718096;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #a0aec0;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Header -->
        <div class="header">
            <h1>{{ $portfolio->full_name }}</h1>
            @if($portfolio->profession)
            <div class="profession">{{ $portfolio->profession }}</div>
            @endif
        </div>

        <!-- Contact Information -->
        <div class="contact-bar">
            @if($portfolio->email)
            <span class="contact-item">✉ {{ $portfolio->email }}</span>
            @endif
            
            @if($portfolio->phone)
            <span class="contact-item">☎ {{ $portfolio->phone }}</span>
            @endif
            
            @if($portfolio->location)
            <span class="contact-item">📍 {{ $portfolio->location }}</span>
            @endif
            
            @if($portfolio->website)
            <span class="contact-item">🌐 {{ $portfolio->website }}</span>
            @endif
        </div>

        <!-- About / Bio -->
        @if($portfolio->bio)
        <div class="section">
            <div class="section-title">About Me</div>
            <div class="section-content">
                <p>{{ $portfolio->bio }}</p>
            </div>
        </div>
        @endif

        <!-- Skills -->
        @if($portfolio->skills && count($portfolio->skills) > 0)
        <div class="section">
            <div class="section-title">Skills</div>
            <div class="section-content">
                <div class="skills-list">
                    @foreach($portfolio->skills as $skill)
                    <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Projects -->
        @if($portfolio->projects && count($portfolio->projects) > 0)
        <div class="section">
            <div class="section-title">Projects</div>
            <div class="section-content">
                @foreach($portfolio->projects as $project)
                <div class="project-item">
                    <div class="project-title">{{ $project['title'] ?? 'Untitled Project' }}</div>
                    @if(isset($project['url']))
                    <div class="project-url">{{ $project['url'] }}</div>
                    @endif
                    @if(isset($project['description']))
                    <div class="project-description">{{ $project['description'] }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Work Experience -->
        @if($portfolio->experiences && count($portfolio->experiences) > 0)
        <div class="section">
            <div class="section-title">Work Experience</div>
            <div class="section-content">
                @foreach($portfolio->experiences as $exp)
                <div class="experience-item">
                    <div class="experience-header">
                        <div class="experience-position">{{ $exp['position'] ?? 'Position' }}</div>
                        @if(isset($exp['period']))
                        <div class="experience-period">{{ $exp['period'] }}</div>
                        @endif
                    </div>
                    <div class="experience-company">{{ $exp['company'] ?? 'Company' }}</div>
                    @if(isset($exp['description']))
                    <div class="experience-description">{{ $exp['description'] }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Education -->
        @if($portfolio->educations && count($portfolio->educations) > 0)
        <div class="section">
            <div class="section-title">Education</div>
            <div class="section-content">
                @foreach($portfolio->educations as $edu)
                <div class="education-item">
                    <div class="education-degree">{{ $edu['degree'] ?? 'Degree' }}</div>
                    <div class="education-school">{{ $edu['school'] ?? 'School' }}</div>
                    @if(isset($edu['period']))
                    <div class="education-period">{{ $edu['period'] }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            Generated by Portify • {{ now()->format('F j, Y') }}
        </div>

    </div>
</body>
</html>