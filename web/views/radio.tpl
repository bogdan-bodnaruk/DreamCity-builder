<table class="data_table">
    <tr>
        <td>##radio->[name=radio1;text=$[text 1,text 2,text 3];value=$[3,2,1]]##</td>
        <td>
            <span class="code">&#35;#radio->[name=radio1;text=$[text 1,text 2,text 3];value=$[3,2,1]]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##radio->[name=radio2;text={data::array};value={data::array};class=test_class;]##</td>
        <td>
            <span class="code">&#35;#radio->[name=radio2;text=&#123;data::array&#125;;value=&#123;data::array&#125;;class=test_class;]#&#35;</span>
        </td>
    </tr>
    <tr>
        <td>##radio->[name=radio3;checked=qwe;text={data::array};value={data::array};]##</td>
        <td>
            <span class="code">&#35;#radio->[name=radio3;checked=qwe;text=&#123;data::array&#125;;value=&#123;data::array&#125;;]#&#35;</span>
        </td>
    </tr>
</table>
<div style="padding: 10px;">
    <h2 style="color: #00008b;">Details:</h2>
    <table class="info_table">
        <tr>
            <td>name</td>
            <td> - Name of select. Default: [chars | mixed];</td>
        </tr>
        <tr>
            <td>value</td>
            <td> - Value: [<a href="ui/array/">array</a>];</td>
        </tr>
        <tr>
            <td>text</td>
            <td> - Value: [<a href="ui/array/">array</a>];</td>
        </tr>
        <tr>
            <td>checked</td>
            <td> - Some value from values; Value [char, num, mixed]</td>
        </tr>
        <tr>
            <td>class</td>
            <td> - Value: [num | chars | mixed];</td>
        </tr>
    </table>
</div>