<tr>
    <td>
        <table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="width: 570px; margin: 0 auto;">
            <tr>
                <td style="background-color: #e9ac30; height: 4px; font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>
            <tr>
                <td align="center" style="background-color: #fdf8f0; padding: 20px 32px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>