@component('mail::message')
# {{trans('messages.hello')}} {{$name}}

@if(count($failures) == 0)
{{ trans('reports.products_imported') }}
@else
{{ trans('reports.imported_errors') }}<br>
{{ trans('reports.errors') }}: {{ count($failures) }}
@endif

@if(count($failures) > 0)
<table class="table">
<thead>
<tr>
<th>{{ trans('reports.row') }}</th>
<th>{{ trans('reports.field') }}</th>
<th>{{ trans('reports.errors') }}</th>
</tr>
</thead>
<tbody>
@foreach($failures as $failure)
<tr>
<td>{{ $failure->row }}</td>
<td>{{ $failure->attribute }}</td>
<td>{{ $failure->errors }}</td>
</tr>
@endforeach
</tbody>
</table>
@endif
<br>
{{ config('app.name') }}
@endcomponent
