<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import "qalendar/dist/style.css";
import {
    mdiPlus,
    mdiTimetable,
    mdiDelete,
    mdiPencil
} from "@mdi/js";
import {
    Qalendar
} from "qalendar";
export default {
    layout: AuthenticatedLayout,
    components: {
        Qalendar,
    },
    props: ["emplois", "seances"],
    data() {
        return {
            icons: {
                mdiPlus,
                mdiTimetable,
                mdiPencil,
                mdiDelete
            },
            config: {
                locale: "fr-FR",
                defaultMode: "week",
                style: {
                    colorSchemes: {
                        meetings: {
                            color: "#fff",
                            backgroundColor: "#131313",
                        },
                        sports: {
                            color: "#fff",
                            backgroundColor: "#ff4081",
                        },
                    },
                },
            },

        }
    },
}
</script>
<template>
<Qalendar :selected-date="new Date()" :events="seances">
    <template #weekDayEvent="eventProps">
        <div :style="{ backgroundColor: 'cornflowerblue', color: '#01579B', width: '100%', height: '100%', overflow: 'hidden' }">
            <span>{{ timeFormattingFunction(eventProps.eventData.time) }}</span>

            <span>{{ eventProps.eventData.title }}</span>
        </div>
    </template>

    <template #monthEvent="monthEventProps">
        <span>{{ monthEventProps.eventData.title }}</span>
    </template>
</Qalendar>
</template>
