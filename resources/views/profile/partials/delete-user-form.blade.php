<form method="post" action="{{ route('profile.destroy') }}">
    @csrf
    @method('delete')

    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition" onclick="return confirm('Are you sure you want to delete your account?')">
        Delete Account
    </button>
</form>