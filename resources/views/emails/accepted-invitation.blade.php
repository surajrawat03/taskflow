<div style="font-family: Arial, sans-serif; background: #f9fafb; padding: 24px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #e5e7eb; padding: 32px;">
        <h2 style="color: #4f46e5;">Invitation Accepted!</h2>
        <p>Hello {{ $inviter->name }},</p>
        <p>
            Good news! <strong>{{ $newMember->name }}</strong> ({{ $newMember->email }}) has accepted your invitation and joined the project <strong>{{ $project->name }}</strong> as a <strong>{{ ucfirst($invitation->role) }}</strong>.
        </p>
        <p>
            You can now collaborate together on your project.
        </p>
        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e5e7eb;">
        <p style="font-size: 12px; color: #9ca3af;">If you did not expect this, you can safely ignore this email.</p>
        <p style="font-size: 12px; color: #9ca3af;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div> 