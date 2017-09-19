<template>
    <div>
        <button v-if="userHomeButton" @click="usersHomeTimeline">My Timeline</button>
        <div class="row">
            <div class="col-md-6" v-for="tweet in tweets">
                <div class="tweet-card">
                    <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ tweet.user.name }}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">@{{ tweet.user.screen_name }}</h6>
                        <p class="card-text">{{ tweet.text }}</p>
                    </div>
                    <div class="card-footer">
                      <small class="text-muted">Last updated 3 mins ago</small>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data: function () {
            return {
                userHomeButton: false,
                tweets: []
            }
        },

        methods: {
            usersHomeTimeline() {
                axios.get('/api/tweets/home')
                    .then((response) => {
                        this.tweets = [];
                        this.tweets = response.data;
                        this.userHomeButton = false;
                        console.log(this.tweets);
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }
        },

        created() {

            this.usersHomeTimeline();

            Event.$on('updateUserTweets', (id) => {
                axios.get('/api/tweets/users/' + id)
                    .then((response) => {
                        this.tweets = [];
                        this.tweets = response.data;
                        this.userHomeButton = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            });
        }
    }
</script>
