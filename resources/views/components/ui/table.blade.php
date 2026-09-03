@props([
    'headers' => [],
    'pagination' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col bg-white rounded-2xl border border-zinc-200/80 shadow-3xs overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            @if(!empty($headers))
                <thead>
                    <tr class="bg-surface-subtle border-b border-zinc-200/80">
                        @foreach($headers as $header)
                            <th scope="col" class="py-3.5 px-6 text-label uppercase tracking-wider font-extrabold text-zinc-600 select-none">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-zinc-200/70 text-body-sm text-zinc-700">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if($pagination)
        <div class="px-6 py-3.5 border-t border-zinc-100 bg-surface-subtle">
            {{ $pagination }}
        </div>
    @endif
</div>
