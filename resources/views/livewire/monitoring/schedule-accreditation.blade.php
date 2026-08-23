<div>
    <flux:modal wire:model="showModal" name="schedule-accreditation" class="w-full max-w-lg">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Schedule Accreditation</flux:heading>
                <flux:subheading>Initiate a new accreditation process for a program.</flux:subheading>
            </div>

            <flux:select wire:model="program_id" label="Program">
                <option value="" disabled selected>Select a program...</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->college->code ?? '' }} - {{ $program->name }}</option>
                @endforeach
            </flux:select>

            <flux:input type="date" wire:model="target_date" label="Target Accreditation Date" />

            <div class="flex justify-end gap-2 mt-4">
                <flux:button type="button" x-on:click="$flux.modal('schedule-accreditation').close()">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Schedule Visit</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
