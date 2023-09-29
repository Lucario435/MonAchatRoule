@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://cdn.discordapp.com/attachments/1149051976550731906/1149052038769016862/Logo-Slogan.png?ex=65171a9a&is=6515c91a&hm=3b61cc8827ad4382841208d81922184c2ecd7ca83655fd4d40b37a7e61a54f77&" class="logo" alt="MonAchatRoule Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
