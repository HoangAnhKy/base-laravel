@extends("Layout.default")
@section("content")
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6">
            <form class="form mt-5" action="{{ route("register-save") }}" method="post">
                @csrf
                <h3 class="text-center text-dark">Register</h3>
                <div class="form-group">
                    <label for="name" class="text-dark">Name:</label><br>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old("name", "")}}">
                    @error('name')
                    <span id="validationFeedbackName" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="email" class="text-dark">Email:</label><br>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old("email", "")}}">
                    @error('email')
                    <span id="validationFeedbackEmail" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="password" class="text-dark">Password:</label><br>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old("password", "")}}">
                    @error('password')
                    <span id="validationFeedbackPassword" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="confirm-password" class="text-dark">Confirm Password:</label><br>
                    <input type="password" name="confirm-password" id="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" value="{{ old("confirm-password", "")}}">
                    @error('confirm-password')
                    <span id="validationFeedbackConfirmPassword" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="remember-me" class="text-dark"></label><br>
                    <input type="submit" name="submit" class="btn btn-dark btn-md" value="submit">
                </div>
                <div class="text-right mt-2">
                    <a href="/login" class="text-dark">Login here</a>
                </div>
            </form>
        </div>
    </div>
@endsection
