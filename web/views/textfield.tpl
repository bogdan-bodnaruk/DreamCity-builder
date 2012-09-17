<table class="data_table">
    <tr>
        <td>##text->[name=text1;size=20;]##</td>
        <td>
            <span class="code">Code: &#35;#text->[name=text1;size=20;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##text->[name=text2;size=19;placeholder=text text]##</td>
        <td>
            <span class="code">Code: &#35;#text->[name=text2;size=19;placeholder=test text;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##text->[name=text3;size=20;value={text}]##</td>
        <td>
            <span class="code">Code: &#35;#text->[name=text3;size=20;value={text};]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##text->[name=text4;id=test_id;class=test_class;style=font-size:14px+border:1px solid red;]##</td>
        <td>
            <span class="code">Code: &#35;#text->[name=text4;id=test_id;class=test_class;style=font-size:14px+border:1px solid red;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##text->[name=text5;size=20;]##</td>
        <td>
            <span class="code">Code: &#35;#text->[name=text5;size=20;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##text->[name=text6;size=20;required=false;js=onClick:alert(1);]##</td>
        <td>
            <span class="code">Code: &#35;#text->[name=text6;size=20;required=false;js=onClick:alert(1);]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##password->[name=text6;size=20;]##</td>
        <td>
            <span class="code">Code: &#35;#password->[name=text6;size=20;]#&#35;</span>
        </td>
    </tr>
</table>

<div style="padding: 10px;">
    <h2 style="color: #00008b;">Details:</h2>
    <table class="info_table">
        <tr>
            <td>required</td>
            <td> - This field can be empty. Values: [true, false]. Default: [true];</td>
        </tr>
        <tr>
            <td>name</td>
            <td> - Name of textfield. Default: [chars | mixed];</td>
        </tr>
        <tr>
            <td>size</td>
            <td> - Size of chars and maxlenght of field. Value: [num]. Default: [15];</td>
        </tr>
        <tr>
            <td>max, min</td>
            <td>
                - Maxlength and Minlength. Value: [num]. Default: [0, 1000]
            </td>
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
        <tr>
            <td>validate</td>
            <td> - Validate type textfield. Values [none, text, num, phone, email, url, dateYYYYmmdd, datemmddYYYY, url, login];
                Default: [text];</td>
        </tr>
    </table>
</div>