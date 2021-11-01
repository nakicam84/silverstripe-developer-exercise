# Additional notes:

JSON API Route: /posts/json

This setup is under a 'public' directory. Eg. E.g /var/www/public/app, /var/www/public/assets etc

# Media Suite Silverstripe Coding Exercise

We’d like you to build a blogging platform!

This is designed as a relatively simple exercise to get some code we can talk about in our technical interview. Not all developers have code that they can share with us due to IP restrictions, and this provides a common scenario across all candidates that provides some level of objective measure.

Please spend no more than two hours on this task. We respect your time far too much to ask for more than that. If you don’t finish, that’s fine, we’ll talk through what you have completed.

Please fork [https://github.com/mediasuitenz/silverstripe-coding-exercise](https://github.com/mediasuitenz/silverstripe-coding-exercise) and either email us a link to your public repo or zip up the source code and send it in. Please don’t include any dependencies folders (e.g. `/vendor`), we'll regenerate dependencies from the `composer.json` and `composer.lock` files as part of testing the code.

If we can’t figure out how to get your application running it really limits how useful the exercise is, so please include any instructions we might need to launch it.

Please ask any questions you may have of your Media Suite contact. This is not a test of your ability to understand our written instructions, it really is just an opportunity to write some code.

## The Output

It's okay for this application to look very basic, though this is up to you. For example...

### The list of posts

![List of Posts](./posts.png)

### An individual post

![An individual post](./post.png)
**NOTE**: The post files are in Markdown format, but they should render in the browser as html.

## The Application Functionality

Using the blog post files provided [here](./assets/posts):

- Create two routes:
  - `/posts` - this should present a list of all the post titles. Each title should be a link, and clicking on it should should navigate to the specific post page.
  - `/posts/<slug>` - this should return a specific blog post, including a list of the five most commonly used words in the article, excluding stop-words, as 'tags'. See `tags.php` for the list of stop-words.

### Optional extra

- Create a server API GET endpoint that returns a JSON array of blog articles, where each entry in the array consists of article title, article slug, the tags as an array, and up to 200 characters of summary data.
  E.g. the array should have the structure as below.

```
[
  {
    "title": "The Why Behind Work",
    "slug": "the-why-behind-work",
    "tags": ["work", "opportunity", "job", "important", "good"],
    "summary": "If your only reason for coming to work is to earn some money, then you're missing an opp..."
  }, {
    <... another article ...>
  }
]
```

**NOTE:**

- The `/assets/posts` folder contains text files with blog data in them. The file name is the URL slug.
- The content of each file will be in the following format
  ```
  ===
  Title: Blog Title
  Author: Author Name
  Slug: same-as-filename
  ===
  # Markdown content will live here
  This is some markdown paragraph text
  ```
