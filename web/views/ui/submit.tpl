<table class="data_table">
    <tr>
        <td>##submit->[name=submit1;value=submit]##</td>
        <td>
            <span class="code">Code: &#35;#submit->[name=submit2;value=submit]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##submit->[name=submit3;value=submit;id=test_id;class=test_class;style=font-size:18px;]##</td>
        <td>
            <span class="code">Code: &#35;#submit->[name=submit3;value=submit;id=test_id;class=test_class;style=font-size:18px;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##button->[name=button1;value=button]##</td>
        <td>
            <span class="code">Code: &#35;#button->[name=button1;value=button]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##button->[name=button3;value=button;id=test_id2;class=test_class;style=font-size:10px;]##</td>
        <td>
            <span class="code">Code: &#35;#button->[name=button3;value=button;id=test_id2;class=test_class;style=font-size:10px;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##submit->[name=submit4;value=delete;class=red;]##</td>
        <td>
            <span class="code">Code: &#35;#submit->[name=submit4;value=delete;class=red;]#&#35;</span>
        </td>
    </tr>
</table>

<div style="padding: 10px;">
    <h2 style="color: #00008b;">Details:</h2>
    <table class="info_table">
        <tr>
            <td>name</td>
            <td> - Name of submit or button. Default: [chars | mixed];</td>
        </tr>
        <tr>
            <td>value</td>
            <td> - Value: [num | chars | mixed];</td>
        </tr>
        <tr>
            <td>id, class</td>
            <td> - Value: [num | chars | mixed];</td>
        </tr>
        <tr>
            <td>style</td>
            <td> - Inline style. New line start after + (plus) ; Value: [css styles];</td>
        </tr>
        <tr>
            <td>js</td>
            <td>- Inline javascript code. First action e.q. (onClick) than : and code; new line start after + (plus)
                Values type by + (plus); Value: [js code];</td>
        </tr>
    </table>
</div>