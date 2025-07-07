<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Invitation</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }
        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e0e7ff;
        }
        .icon svg {
            width: 24px;
            height: 24px;
            color: #4f46e5;
        }
        .title {
            margin-left: 12px;
        }
        h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            color: #111827;
        }
        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }
        .section {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }
        .value {
            font-size: 16px;
            color: #111827;
            padding: 8px 12px;
            background-color: #f9fafb;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .message {
            white-space: pre-line;
            background-color: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            padding: 10px 16px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #4338ca;
        }
        .footer {
            margin-top: 24px;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div class="title">
                <h1>Team Invitation</h1>
                <p class="subtitle">You've been invited to join a team</p>
            </div>
        </div>

        <div class="section">
            <p>Hello,</p>
            <p>You've been invited by {{ $inviter->name }} to join project team at {{ config('app.name') }}.</p>
        </div>

        <div class="section">
            <span class="label">Project</span>
            <div class="value">{{ $project->name }}</div>
        </div>

        <div class="section">
            <span class="label">Role</span>
            <div class="value">
                {{ ucfirst($invitation->role) }}
                @if($invitation->role === 'member')
                    - Can view and manage assigned tasks
                @elseif($invitation->role === 'manager')
                    - Can manage projects and assign tasks
                @elseif($invitation->role === 'admin')
                    - Full access to all projects and team management
                @endif
            </div>
        </div>

        @if(!empty($invitation->message))
        <div class="section">
            <span class="label">Personal Message</span>
            <div class="message">{{ $invitation->message }}</div>
        </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ URL::temporarySignedRoute('accept-invitation', now()->addDays(7), ['id' => $invitation->id, 'email' => $invitation->email]) }}" class="button">Accept Invitation</a>
            <p style="font-size: 12px; color: #6b7280; margin-top: 8px;">
                This link expires in 7 days
            </p>
        </div>

        <div class="footer">
            <p>If you didn't request this invitation, you can safely ignore this email.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>