<template>
    <div class="row">
            <draggable
                class="list-group"
                tag="ul"
                v-model="list"
                v-bind="dragOptions"
                @start="drag = true"
                @end="drag = false"
            >
                <transition-group type="transition" :name="!drag ? 'flip-list' : null">
                    <li
                        class="list-group-item alert-success full-width"
                        v-for="element in list"
                        :key="element.order"
                    >
                        <i
                            :class="
                element.fixed ? 'mdi mdi-sort' : 'mdi mdi-arrow-up-down'
              "
                            @click="element.fixed = !element.fixed"
                            aria-hidden="true"
                        ></i>
                        {{element.order + ' '}}{{ element.title }}
                    </li>
                </transition-group>
            </draggable>
        <br/>
        <br/>
        <div class="text-center">
            <button class="btn btn-secondary" @click="update">Update Sequences</button>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import axios from 'axios';
export default {
    name: "Sortable",
    props: {
        campaign: Object,
        sequences: Array,
        route: String
    },
    display: "Transitions",
    order: 7,
    components: {
        draggable
    },
    data() {
        return {
            list: this.sequences.map(({id, title, order}, index) => {
                return { id, title, order };
            }),
            drag: false
        };
    },
    created() {
        this.list.sort((a, b) => a.order < b.order);
    },
    methods: {
        sort() {
            this.list = this.list.sort((a, b) => a.order - b.order);
        },
        update: function() {
            console.log(this.list);
            this.postData();
        },
        postData() {
            axios.post(this.route, this.list)
                .then(function (response) {
                    if(response.data.code === 200) {
                        alert(response.data.message);
                        location.reload();
                    } else {
                        alert(response.data.message);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    alert(error.message);
                });

        }
    },
    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
        }
    }
}
</script>

<style scoped>
ul, .list-group {
    width: 100% !important;
}
.button {
    margin-top: 35px;
}
.flip-list-move {
    transition: transform 0.5s;
}
.no-move {
    transition: transform 0s;
}
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}
.list-group {
    min-height: 20px;
}
.list-group-item {
    margin-bottom: 5px;
    color: #2a303a;
    background: rgba(144,238,144, 0.2);
    cursor: move;
}
.list-group-item i {
    cursor: pointer;
}
.full-width {
    width: 100% !important;
}
</style>
