@props(['url'])
<tr>
    <td style="background-color: #5c1010; padding: 28px 40px; text-align: center;">
        <a href="{{ $url }}" style="
            color: #f5c842;
            font-size: 22px;
            font-weight: bold;
            text-decoration: none;
            letter-spacing: 1px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        ">
            &#127979; {{ $slot }}
        </a>
    </td>
</tr>
<tr>
    <td style="background-color: #e9ac30; height: 4px; font-size: 0; line-height: 0;">&nbsp;</td>
</tr>