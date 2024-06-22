<!-- resources/views/profile/partials/update-phone-form.blade.php -->

<form method="POST" action="{{ route('profile.update-phone') }}">
    @csrf
    @method('PUT')

    <!-- Phone Number -->
    <div>
        <x-input-label for="phone" :value="__('Phone')" />
        <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone', auth()->user()->phone)" required
            pattern="[0-9]+" autocomplete="tel" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4">
            {{ __('Update Phone') }}
        </x-primary-button>
    </div>
</form>
