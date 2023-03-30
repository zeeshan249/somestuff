<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'FutureOrbit')
<img src="{{config('customconfig.companyLogoImageUrl')  }}" class="logo" alt="{{ __('label.label_company_name') }}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
