@if (Session::has('success'))
    <div id="success">
        <p>{{ Session::get('success') }}</p>
    </div>
@endif
@if (Session::has('fail'))
    <div id="fail">
        <p>{{ Session::get('fail') }}</p>
    </div>
@endif
@if (Session::has('info'))
    <div id="info">
        <p>{{ Session::get('info') }}</p>
    </div>
@endif