<template>
    <!-- Messages: style can be found in dropdown.less-->
    <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning" v-text="notifications.length"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <ul class="menu">
                    <li v-for="notification in notifications">
                        <a @click="markAsRead(notification)" v-text="notification.data.message"></a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: []
            }
        },
        mounted() {
            axios.get('notifications').then(res => {
                this.notifications = res.data;
            })
        },
        methods: {
          markAsRead(notification) {
              axios.patch('notifications/' + notification.id);
          }
        }
    }
</script>
