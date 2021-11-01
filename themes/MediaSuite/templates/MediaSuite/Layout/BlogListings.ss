<ul>
<% loop $BlogPosts %>
    <li><a href="$Top.Link($Slug)">$Title</a> </li>
  <% end_loop %>
</ul>
