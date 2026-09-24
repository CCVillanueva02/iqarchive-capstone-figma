<script setup>
/**
 * StatusBadge.vue
 * Reusable DaisyUI badge component for AACCUP document lifecycle and accreditation states.
 * 
 * Complies with UI standards: strictly uses DaisyUI badge component classes.
 */
import { computed } from 'vue';

const props = defineProps({
    status: {
        type: String,
        required: true,
        default: 'draft',
    },
    size: {
        type: String,
        default: 'sm', // 'xs', 'sm', 'md', 'lg'
    },
});

const config = computed(() => {
    switch (props.status?.toLowerCase()) {
        case 'active':
        case 'approved':
            return {
                label: 'Approved',
                badgeClass: 'badge-success badge-soft text-success-content',
            };
        case 'submitted':
        case 'endorsed':
            return {
                label: 'Submitted',
                badgeClass: 'badge-info badge-soft text-info-content',
            };
        case 'under_review':
        case 'in_progress':
            return {
                label: 'Under Review',
                badgeClass: 'badge-primary badge-soft text-primary-content',
            };
        case 'needs_revision':
        case 'inactive':
            return {
                label: 'Needs Revision',
                badgeClass: 'badge-warning badge-soft text-warning-content',
            };
        case 'deficit':
        case 'rejected':
            return {
                label: 'Deficit',
                badgeClass: 'badge-error badge-soft text-error-content',
            };
        case 'draft':
        default:
            return {
                label: 'Draft',
                badgeClass: 'badge-neutral badge-soft text-base-content/70',
            };
    }
});

const sizeClass = computed(() => {
    return props.size ? `badge-${props.size}` : 'badge-sm';
});
</script>

<template>
    <span :class="['badge font-medium tracking-wide', config.badgeClass, sizeClass]">
        {{ config.label }}
    </span>
</template>
