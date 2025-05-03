<div class="fi-fo-month-picker">
    <input
        type="month"
        x-data="{
            updateModel(value) {
                const [year, month] = value.split('-');
                const date = new Date(year, month, 1);
                $wire.$set('{{ $getStatePath() }}', date.toISOString().split('T')[0]);
            }
        }"
        x-on:change="updateModel($event.target.value)"
        {{
            $attributes
                ->merge($getExtraAttributes())
                ->class(['fi-fo-month-picker-input...'])
        }}
        value="{{ $getState() ? \Carbon\Carbon::parse($getState())->format('Y-m') : '' }}"
    />
</div>