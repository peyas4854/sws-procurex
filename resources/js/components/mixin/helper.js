export default {
    methods: {
        badgeClass(value) {
            let style;

            if (value == 'approved') {
                style = 'badge-success';
            } else if (value == 'rejected') {
                style = 'badge-danger';
            } else if (value == 'draft') {
                style = 'badge-dark';
            } else if (value == 'reverted') {
                style = 'badge-secondary';
            } else if (value == 'pending') {
                style = 'badge-warning';
            } else if (value == 'resubmitted') {
                style = 'badge-primary';
            } else style = 'badge-info';

            return style;
        }
    },

}
