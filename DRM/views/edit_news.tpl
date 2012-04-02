<form action="edit/news/" method="post">
    <p>##lang->[name=lang;selected={lang}]##</p>
    <p>##text->[name=theme;placeholder=theme;value={theme}]##</p>
    <p>##textarea->[name=short_text;value={short_text};placeholder=Please enter short text here!;]##</p>
    <p>##textarea->[name=full_text;value={full_text};placeholder=Please enter long text here!;]##</p>
    <p>##permissions->[name=protect;selected={protect}]##</p>
    <p>##radio->[name=comment;checked={comment};value={comments};text={comments}]##</p>
    <p>##submit->[name=submit;value=Save]##</p>
</form>