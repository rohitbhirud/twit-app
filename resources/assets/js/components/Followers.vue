<template>
    <div>
        <input class="form-control" name="search" v-model="search" placeholder="search..." />

    	<ul class="list-group">
    		<li class="list-group-item" v-for="follower in filteredFollowers">
    			<a href="#" @click="updateUserTweets(follower.id)">{{ follower.name }}</a>
    		</li>
    	</ul>

    </div>
</template>

<script>
    export default {

        data: function () {
            return {
                search: '',
                followers: []
            }
        },

        computed: {
            filteredFollowers() {
                return this.followers.filter(follower => {
                    return follower.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                })
            }
        },

        methods: {
            updateUserTweets(id) {
                Event.$emit('updateUserTweets', id);
            }
        },

        created() {
            axios.get('/api/followers')
                .then((response) => {
                    this.followers = response.data.slice(0, 10);
                })
                .catch((error) => {
                    console.log(error);
                })
        }
    }
</script>
