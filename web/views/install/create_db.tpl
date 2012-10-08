<div style="width: 300px;margin: 50px auto;text-align: right;">
    <div class="h2_title">Create DB</div>
    <form method="post" action="install/create_db">
        <p>
            Name: ##text->[name=table;value={config::db_table};min=3;max=100]##
        </p>
        <p>
            ##submit->[name=submit;value=Go!]##
        </p>
    </form>
</div>