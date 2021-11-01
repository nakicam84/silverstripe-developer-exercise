<h1>$Title</h1>
$Content
<hr>
<h3>Tags:</h3>
<% loop $Tags %>
    <span class="strong bold">$Tag<% if not $Last %>,<% end_if %></span>
<% end_loop %>
