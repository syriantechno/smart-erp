(function () {
    "use strict";

    // Litepicker
    $(".datepicker").each(function () {
        const currentYear = dayjs().year();
        let options = {
            autoApply: false,
            singleMode: true,
            numberOfColumns: 1,
            numberOfMonths: 1,
            showWeekNumbers: true,
            format: "D MMM, YYYY",
            dropdowns: {
                minYear: 1990,
                maxYear: currentYear + 10,
                months: true,
                years: true,
            },
        };

        if ($(this).data("range")) {
            options.singleMode = false;
            options.numberOfColumns = 2;
            options.numberOfMonths = 2;
        }

        if ($(this).data("format")) {
            options.format = $(this).data("format");
        }

        if (!$(this).val()) {
            let date = dayjs().format(options.format);
            date += !options.singleMode
                ? " - " + dayjs().add(1, "month").format(options.format)
                : "";
            $(this).val(date);
        }

        new Litepicker({
            element: this,
            ...options,
        });
    });
})();
