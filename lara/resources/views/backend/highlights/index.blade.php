<!-- resources/views/backend/highlights/index.blade.php -->

<!DOCTYPE html>
<html>

<head>

    <title>Highlights Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .highlight-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .card {
            border: none;
            border-radius: 15px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <h2 class="mb-4">
            Highlights Manager
        </h2>

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif

        <div class="row">

            @foreach($highlights as $highlight)

                <div class="col-md-4 mb-4">

                    <div class="card shadow-sm p-3">

                        <!-- FIXED IMAGE PATH -->
                        <img src="{{ url('public/' . $highlight->image) }}" class="highlight-image mb-3">
                        <!-- UPDATE FORM -->
                        <form action="{{ url('/highlights/' . $highlight->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <div class="mb-3">

                                <label class="form-label">
                                    Change Image
                                </label>

                                <input type="file" name="image" class="form-control">

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Text
                                </label>

                                <textarea name="text" class="form-control" rows="3"
                                    required>{{ $highlight->text }}</textarea>

                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                Update
                            </button>

                        </form>

                        <!-- DELETE FORM -->
                        <form action="{{ url('/highlights/' . $highlight->id) }}" method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Delete this image?')">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

        <hr class="my-5">

        <!-- ADD NEW HIGHLIGHT -->

        <div class="card shadow p-4">

            <h3 class="mb-4">
                Add New Highlight
            </h3>

            <form action="{{ url('/highlights') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Upload Image
                    </label>

                    <input type="file" name="image" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Text
                    </label>

                    <textarea name="text" class="form-control" rows="4" required></textarea>

                </div>

                <button type="submit" class="btn btn-success">
                    Add Highlight
                </button>

            </form>

        </div>

    </div>

</body>

</html>