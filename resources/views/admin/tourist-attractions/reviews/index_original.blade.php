@extends('admin.dashboard')

@section('content')
<div class="main-content">
    <h2>Reviews for {{ $attraction->name }}</h2>
    <p>Manage visitor reviews and feedback</p>
    
    <a href="{{ route('admin.tourist-attractions') }}" style="display: inline-block; margin-bottom: 20px; padding: 8px 16px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
        ← Back to Tourist Attractions
    </a>

    @if($reviews->count() > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border: 1px solid #dee2e6;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">User</th>
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Rating</th>
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Comment</th>
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Date</th>
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                        <strong>{{ $review->user->name }}</strong><br>
                        <small style="color: #6c757d;">{{ $review->user->email }}</small>
                    </td>
                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                        <br>
                        <small>{{ $review->rating }}/5</small>
                    </td>
                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                        {{ $review->comment }}
                    </td>
                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                        {{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}<br>
                        <small style="color: #6c757d;">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</small>
                    </td>
                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                        <form method="POST" action="{{ route('admin.tourist-attractions.reviews.destroy', $review->id) }}" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 4px 8px; background: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 40px; background: white; border: 1px solid #dee2e6; margin-top: 20px;">
            <p style="color: #6c757d; font-size: 18px;">No reviews found for this tourist attraction.</p>
        </div>
    @endif
</div>
@endsection
