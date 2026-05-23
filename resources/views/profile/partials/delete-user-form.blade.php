<form method="post" action="{{ route('profile.destroy') }}" class="space-y-5">
    @csrf
    @method('delete')

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition" onclick="return confirm('Are you sure you want to delete your account? This cannot be undone.')">
            Delete My Account
        </button>
        <a href="{{ route('profile.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">Cancel</a>
    </div>
</form>