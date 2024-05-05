<template>
    <div>
        <h1>the count is now  {{ views }}</h1>
        <button @click="updateViews(1)">Increase</button>
        <button @click="updateViews(-1)">Decrease</button>
        <br>
        <br><br>

        <div v-for="(blog, i) in blogs" :key="i" v-if="blogs.length">
            <h1>{{ blog.title }}</h1>
            <p>{{ blog.post }}</p>
        </div>

        <br><br><br>

        <div>
            <h1 v-if="showItem">show this item if "showItem" is true</h1>
            <h1 v-else>show this item if "showItem" is false</h1>
        </div>

        <button @click="showItem=!showItem">changetruness</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            views: 0,

            blogs: [],

            showItem: false,
        }
    },
    created() {
        this.views = 100;
        // get the blog posts
        let posts = [
            { title: 'this is the blog title1', post: 'this is the content man', id: 1 },
            { title: 'this is the blog title2', post: 'this is the content man', id: 2 },
            { title: 'this is the blog title3', post: 'this is the content man', id: 3 },
            { title: 'this is the blog title4', post: 'this is the content man', id: 4 },
            { title: 'this is the blog title5', post: 'this is the content man', id: 5 },
            { title: 'this is the blog title6', post: 'this is the content man', id: 6 },
            { title: 'this is the blog title7   ', post: 'this is the content man', id: 7 }];

        this.blogs = posts;
    },
    methods: {
        updateViews( number) {
            this.views += number;
        }
    }
}
</script>