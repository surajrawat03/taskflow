<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation Accepted</title>
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
            background-color: #d1fae5;
        }
        .icon svg {
            width: 24px;
            height: 24px;
            color: #059669;
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
        .success-message {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #a7f3d0;
            margin-bottom: 20px;
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="title">
                <h1>Invitation Accepted</h1>
                <p class="subtitle">Great news! Your invitation has been accepted</p>
            </div>
        </div>

        <div class="success-message">
            <strong>🎉 Congratulations!</strong> {{ $acceptedUser->name }} has accepted your invitation to join the project.
        </div>

        <div class="section">
            <p>Hello,</p>
            <p>We're pleased to inform you that {{ $acceptedUser->name }} has accepted your invitation to join the project team at {{ config('app.name') }}.</p>
        </div>

        <div class="section">
            <span class="label">Project</span>
            <div class="value">{{ $project->name }}</div>
        </div>

        <div class="section">
            <span class="label">New Team Member</span>
            <div class="value">{{ $acceptedUser->name }} ({{ $acceptedUser->email }})</div>
        </div>

        <div class="section">
            <span class="label">Role Assigned</span>
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

        <div class="section">
            <p>You can now collaborate with {{ $acceptedUser->name }} on the project. They will have access to the project based on their assigned role.</p>
        </div>

        <div class="footer">
            <p>Thank you for using {{ config('app.name') }} for your project management needs.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 