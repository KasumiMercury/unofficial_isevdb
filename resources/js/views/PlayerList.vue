<template>
    <div>
        <p>横にスライドできます</p>
        <b-table
            responsive
            hover
            :items="players"
            :fields="fields"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :style="'white-space : nowrap;'"
        >
            <template #cell(num)="data">
                {{ data.index + 1 }}
            </template>
            <template #cell(formatted_date)="data">
                {{ data.item.date | moment("YYYY/MM/DD") }}
            </template>
            <template #cell(play)="data">
                <b-button v-if="data.item.status == 2" disabled size="sm"
                    ><i class="fas fa-times fa-fw"></i> private
                </b-button>
                <b-button
                    v-else-if="data.item.status == 1"
                    size="sm"
                    class="member"
                    v-on:click="
                        $router.push('/' + member + '/player/' + data.item.id)
                    "
                    ><i class="fas fa-play fa-fw"></i> MemberOnly
                </b-button>
                <b-button
                    v-else
                    size="sm"
                    class="play"
                    v-on:click="
                        $router.push('/' + member + '/player/' + data.item.id)
                    "
                    ><i class="fas fa-play fa-fw"></i> Player
                </b-button>
            </template>
            <template #cell(edit)="data">
                <p class="mr-1">{{ data.item.status }}</p>
            </template>
        </b-table>
    </div>
</template>

<script>
import PlayerModal from "./PlayerModal";
export default {
    props: ["current_member"],
    data() {
        return {
            member: this.$route.params.member,
            cate: this.$route.params.cate,

            sortBy: "id",
            sortDesc: true,
            fields: [
                { key: "num", label: "No." },
                { key: "play", label: "PLAY" },
                { key: "title", label: "TITLE", sortable: true },
                { key: "formatted_date", label: "DATE", sortable: true },
                { key: "id", label: "PlayerID", sortable: true },
            ],
            players: [],
        };
    },
    created() {
        axios
            .get("/api/" + this.member + "/" + this.cate)
            .then((response) => (this.players = response.data.players))
            .catch((error) => console.log(error));
    },
    beforeRouteUpdate(to, from, next) {
        this.cate = to.params.cate;
        this.member = to.params.member;
        axios
            .get("/api/" + this.member + "/" + this.cate)
            .then((response) => (this.players = response.data.players))
            .catch((error) => console.log(error));
        next();
    },
    computed: {
        styles() {
            return {
                "--BtnCol": this.current_member.BtnCol,
            };
        },
    },
    components: {
        PlayerModal,
    },
};
</script>
<style lang="scss">
tr {
    border-color: var(--BtnCol);
}
.play {
    background-color: #c4302b;
    border-color: #c4302b;
}
.member {
    background-color: #70b87c;
    border-color: #70b87c;
}
.sr-only {
    display: none;
}
</style>
