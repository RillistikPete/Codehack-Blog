
@extends('layouts.admin')

@section('content')

    <h1>Media</h1>

    @if($photos)

    <form action="{{ route('media.bulk-destroy') }}" method="post" class="form-inline"
        onsubmit="return confirm('Delete the selected photos?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Selected</button>

        <table class='table table-hover'>
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all"></th>
                    <th>Id</th>
                    <th>Photo</th>
                    <th>File</th>
                    <th>Used By</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($photos as $photo)
                    <tr>
                        <td><input type="checkbox" name="photos[]" value="{{ $photo->id }}"></td>
                        <td>{{$photo->id}}</td>
                        <td><x-photo :photo="$photo" height="50" /></td>
                        <td>{{ $photo->file }}</td>
                        <td>
                            @foreach ($photo->posts as $post)
                                <a href="{{ route('posts.edit', $post->id) }}">{{ Str::limit($post->title, 25) }}</a><br>
                            @endforeach
                            @foreach ($photo->users as $user)
                                <a href="{{ route('users.edit', $user->id) }}">{{ $user->name }}</a><br>
                            @endforeach
                            @if ($photo->posts->isEmpty() && $photo->users->isEmpty())
                                <span class="text-muted">Unused</span>
                            @endif
                        </td>
                        <td>{{$photo->created_at ? $photo->created_at : 'no date'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> 
        <div class="text-center">{{ $photos->links() }}</div>
    </form>

    <div class="text-center">{{ $photos->links() }}</div>
    @endif 

@section('scripts')
<script>
    $('#check-all').on('change', function () {
        $('input[name="photos[]"]').prop('checked', this.checked);
    });
</script>
@endsection

@stop