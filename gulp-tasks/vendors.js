'use strict'
var gulp = require('gulp');
var concat = require('gulp-concat');
var merge = require('merge-stream');
const del = require('del');


gulp.task('clean:vendors', function () {
    return del([
      './assets/vendors/**/*'
    ]);
});

/*Building vendor scripts needed for basic template rendering*/
gulp.task('buildBaseVendorScripts', function() {
    return gulp.src([
        './node_modules/jquery/dist/jquery.min.js', 
        './node_modules/popper.js/dist/umd/popper.min.js', 
        './node_modules/bootstrap/dist/js/bootstrap.min.js', 
        './node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js'
    ])
      .pipe(concat('vendor.bundle.base.js'))
      .pipe(gulp.dest('./assets/vendors/js'));
});

/*Building vendor styles needed for basic template rendering*/
gulp.task('buildBaseVendorStyles', function() {
    return gulp.src(['./node_modules/perfect-scrollbar/css/perfect-scrollbar.css'])
      .pipe(concat('vendor.bundle.base.css'))
      .pipe(gulp.dest('./assets/vendors/css'));
});

/*Scripts for addons*/
gulp.task('buildOptionalVendorScripts', function() {
    var aScript1 = gulp.src(['node_modules/chart.js/dist/Chart.min.js'])
        .pipe(gulp.dest('./assets/vendors/chart.js'));
    var aScript2 = gulp.src(['node_modules/jquery-bar-rating/dist/jquery.barrating.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aScript3 = gulp.src(['node_modules/jquery-sparkline/jquery.sparkline.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-sparkline')); 
    var aScript4 = gulp.src(['node_modules/progressbar.js/dist/progressbar.min.js'])
        .pipe(gulp.dest('./assets/vendors/progressbar.js'));
    var aScript5 = gulp.src(['node_modules/moment/moment.js'])
        .pipe(gulp.dest('./assets/vendors/moment'));
    var aScript6 = gulp.src(['node_modules/fullcalendar/dist/fullcalendar.min.js'])
        .pipe(gulp.dest('./assets/vendors/fullcalendar'));
    var aScript7 = gulp.src(['node_modules/d3/dist/d3.min.js'])
        .pipe(gulp.dest('./assets/vendors/d3'));
    var aScript8 = gulp.src(['node_modules/c3/c3.js'])
        .pipe(gulp.dest('./assets/vendors/c3'));
    var aScript9 = gulp.src(['node_modules/chartist/dist/chartist.min.js'])
        .pipe(gulp.dest('./assets/vendors/chartist'));
    var aScript10 = gulp.src(['node_modules/flot/jquery.flot.js'])
        .pipe(gulp.dest('./assets/vendors/flot'));
    var aScript11 = gulp.src(['node_modules/flot/jquery.flot.resize.js'])
        .pipe(gulp.dest('./assets/vendors/flot'));
    var aScript12 = gulp.src(['node_modules/flot/jquery.flot.categories.js'])
        .pipe(gulp.dest('./assets/vendors/flot'));
    var aScript13 = gulp.src(['node_modules/flot/jquery.flot.fillbetween.js'])
        .pipe(gulp.dest('./assets/vendors/flot'));
    var aScript14 = gulp.src(['node_modules/flot/jquery.flot.stack.js'])
        .pipe(gulp.dest('./assets/vendors/flot'));
    var aScript15 = gulp.src(['node_modules/flot/jquery.flot.pie.js'])
        .pipe(gulp.dest('./assets/vendors/flot'));
    var aScript16 = gulp.src(['node_modules/justgage/raphael-2.1.4.min.js'])
        .pipe(gulp.dest('./assets/vendors/justgage'));
    var aScript17 = gulp.src(['node_modules/justgage/justgage.js'])
        .pipe(gulp.dest('./assets/vendors/justgage'));
    var aScript18 = gulp.src(['node_modules/morris.js/morris.min.js'])
        .pipe(gulp.dest('./assets/vendors/morris.js'));
    var aScript19 = gulp.src(['node_modules/raphael/raphael.min.js'])
        .pipe(gulp.dest('./assets/vendors/raphael'));
    var aScript20 = gulp.src(['node_modules/jquery-tags-input/dist/jquery.tagsinput.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-tags-input'));
    var aScript21 = gulp.src(['node_modules/progressbar.js/dist/progressbar.min.js'])
        .pipe(gulp.dest('./assets/vendors/progressbar.js'));
    var aScript22 = gulp.src(['./node_modules/summernote/dist/**/*'])
        .pipe(gulp.dest('./assets/vendors/summernote/dist'));
    var aScript23 = gulp.src(['node_modules/pwstabs/assets/jquery.pwstabs.min.js'])
        .pipe(gulp.dest('./assets/vendors/pwstabs'));
    var aScript24 = gulp.src(['./node_modules/ace-builds/src-min/**/*'])
        .pipe(gulp.dest('./assets/vendors/ace-builds/src-min'));
    var aScript25 = gulp.src(['./node_modules/lightgallery/dist/**/*'])
        .pipe(gulp.dest('./assets/vendors/lightgallery'));
    var aScript26 = gulp.src(['node_modules/inputmask/dist/jquery.inputmask.bundle.js'])
        .pipe(gulp.dest('./assets/vendors/inputmask'));
    var aScript27 = gulp.src(['node_modules/dropify/dist/js/dropify.min.js'])
        .pipe(gulp.dest('./assets/vendors/dropify'));
    var aScript28 = gulp.src(['node_modules/dropzone/dist/dropzone.js'])
        .pipe(gulp.dest('./assets/vendors/dropzone'));
    var aScript29 = gulp.src(['node_modules/jquery-file-upload/js/jquery.uploadfile.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-file-upload'));
    var aScript30 = gulp.src(['node_modules/jquery-asColor/dist/jquery-asColor.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-asColor'));
    var aScript31 = gulp.src(['node_modules/jquery-asGradient/dist/jquery-asGradient.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-asGradient'));
    var aScript32 = gulp.src(['node_modules/jquery-asColorPicker/dist/jquery-asColorPicker.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-asColorPicker'));
    var aScript33 = gulp.src(['node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'])
        .pipe(gulp.dest('./assets/vendors/bootstrap-datepicker'));
    var aScript34 = gulp.src(['node_modules/moment/min/moment.min.js'])
        .pipe(gulp.dest('./assets/vendors/moment'));
    var aScript35 = gulp.src(['node_modules/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js'])
        .pipe(gulp.dest('./assets/vendors/x-editable'));
    var aScript36 = gulp.src(['node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.js'])
        .pipe(gulp.dest('./assets/vendors/tempusdominus-bootstrap-4'));
    var aScript37 = gulp.src(['node_modules/jquery.repeater/jquery.repeater.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery.repeater'));
    var aScript38 = gulp.src(['node_modules/typeahead.js/dist/typeahead.bundle.min.js'])
        .pipe(gulp.dest('./assets/vendors/typeahead.js'));
    var aScript39 = gulp.src(['node_modules/select2/dist/js/select2.min.js'])
        .pipe(gulp.dest('./assets/vendors/select2'));
    var aScript40 = gulp.src(['node_modules/codemirror/lib/codemirror.js'])
        .pipe(gulp.dest('./assets/vendors/codemirror'));
    var aScript41 = gulp.src(['node_modules/codemirror/mode/javascript/javascript.js'])
        .pipe(gulp.dest('./assets/vendors/codemirror'));
    var aScript42 = gulp.src(['node_modules/codemirror/mode/shell/shell.js'])
        .pipe(gulp.dest('./assets/vendors/codemirror'));
    var aScript43 = gulp.src(['node_modules/quill/dist/quill.min.js'])
        .pipe(gulp.dest('./assets/vendors/quill'));
    var aScript44 = gulp.src(['node_modules/simplemde/dist/simplemde.min.js'])
        .pipe(gulp.dest('./assets/vendors/simplemde'));
    var aScript45 = gulp.src(['node_modules/jquery-validation/dist/jquery.validate.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-validation'));
    var aScript46 = gulp.src(['node_modules/bootstrap-maxlength/bootstrap-maxlength.min.js'])
        .pipe(gulp.dest('./assets/vendors/bootstrap-maxlength'));
    var aScript47 = gulp.src(['node_modules/jquery-steps/build/jquery.steps.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-steps'));
    var aScript48 = gulp.src(['node_modules/jquery-mapael/js/jquery.mapael.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-mapael'));   
    var aScript49 = gulp.src(['node_modules/jquery-mapael/js/maps/france_departments.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-mapael'));
    var aScript50 = gulp.src(['node_modules/jquery-mapael/js/maps/world_countries.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-mapael'));
    var aScript51 = gulp.src(['node_modules/jquery-mapael/js/maps/usa_states.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-mapael'));
    var aScript52 = gulp.src(['node_modules/jvectormap/jquery-jvectormap.min.js'])
        .pipe(gulp.dest('./assets/vendors/jvectormap'));
    var aScript53 = gulp.src(['node_modules/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js'])
        .pipe(gulp.dest('./assets/vendors/jvectormap'));
    var aScript54 = gulp.src(['node_modules/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js'])
        .pipe(gulp.dest('./assets/vendors/jvectormap'));
    var aScript55 = gulp.src(['node_modules/datatables.net/js/jquery.dataTables.js'])
        .pipe(gulp.dest('./assets/vendors/datatables.net'));
    var aScript56 = gulp.src(['node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js'])
        .pipe(gulp.dest('./assets/vendors/datatables.net-bs4'));
    var aScript57 = gulp.src(['node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js'])
        .pipe(gulp.dest('./assets/vendors/datatables.net-bs4'));
    var aScript58 = gulp.src(['node_modules/jsgrid/dist/jsgrid.min.js'])
        .pipe(gulp.dest('./assets/vendors/jsgrid'));
    var aScript59 = gulp.src(['node_modules/owl-carousel-2/owl.carousel.min.js'])
        .pipe(gulp.dest('./assets/vendors/owl-carousel-2'));
    var aScript60 = gulp.src(['node_modules/clipboard/dist/clipboard.min.js'])
        .pipe(gulp.dest('./assets/vendors/clipboard'));
    var aScript61 = gulp.src(['node_modules/colcade/colcade.js'])
        .pipe(gulp.dest('./assets/vendors/colcade'));
    var aScript62 = gulp.src(['node_modules/jquery-contextmenu/dist/jquery.contextMenu.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-contextmenu'));
    var aScript63 = gulp.src(['node_modules/dragula/dist/dragula.min.js'])
        .pipe(gulp.dest('./assets/vendors/dragula'));
    var aScript64 = gulp.src(['node_modules/jquery-toast-plugin/dist/jquery.toast.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-toast-plugin'));
    var aScript65 = gulp.src(['node_modules/twbs-pagination/jquery.twbsPagination.min.js'])
        .pipe(gulp.dest('./assets/vendors/twbs-pagination'));
    var aScript66 = gulp.src(['node_modules/sweetalert/dist/sweetalert.min.js'])
        .pipe(gulp.dest('./assets/vendors/sweetalert'));
    var aScript67 = gulp.src(['node_modules/jquery.avgrund/jquery.avgrund.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery.avgrund'));
    var aScript68 = gulp.src(['node_modules/nouislider/distribute/nouislider.min.js'])
        .pipe(gulp.dest('./assets/vendors/nouislider')); 
    var aScript69 = gulp.src(['node_modules/ion-rangeslider/js/ion.rangeSlider.min.js'])
        .pipe(gulp.dest('./assets/vendors/ion-rangeslider/js'));
    var aScript70 = gulp.src(['./node_modules/tinymce/**/*'])
        .pipe(gulp.dest('./assets/vendors/tinymce'));
    var aScript71 = gulp.src(['node_modules/jquery-circle-progress/dist/circle-progress.min.js'])
        .pipe(gulp.dest('./assets/vendors/jquery-circle-progress/js'));
    return merge(aScript1, aScript2, aScript3, aScript4, aScript5, aScript6, aScript7, aScript8, aScript9, aScript10, aScript11, aScript12, aScript13, aScript14, aScript15, aScript16, aScript17, aScript18, aScript19, aScript20, aScript21, aScript22, aScript23, aScript24, aScript25, aScript26  , aScript27, aScript28, aScript29, aScript30, aScript31, aScript32, aScript33, aScript34, aScript35, aScript36, aScript37, aScript38, aScript39, aScript40, aScript41, aScript42, aScript43, aScript44, aScript45, aScript46, aScript47, aScript48, aScript49, aScript50, aScript51, aScript52, aScript53, aScript54, aScript55, aScript56, aScript57, aScript58, aScript59, aScript60, aScript61, aScript62, aScript63, aScript64, aScript65, aScript66, aScript67, aScript68, aScript69, aScript70, aScript71);
});


/*Styles for addons*/
gulp.task('buildOptionalVendorStyles', function() {
    var aStyle1 = gulp.src(['./node_modules/@mdi/font/css/materialdesignicons.min.css'])
        .pipe(gulp.dest('./assets/vendors/mdi/css'));
    var aStyle2 = gulp.src(['./node_modules/@mdi/font/fonts/*'])
        .pipe(gulp.dest('./assets/vendors/mdi/fonts'));
    var aStyle3 = gulp.src(['./node_modules/font-awesome/css/font-awesome.min.css'])
        .pipe(gulp.dest('./assets/vendors/font-awesome/css'));
    var aStyle4 = gulp.src(['./node_modules/font-awesome/fonts/*'])
        .pipe(gulp.dest('./assets/vendors/font-awesome/fonts'));
    var aStyle5 = gulp.src(['./node_modules/flag-icon-css/css/flag-icon.min.css'])
        .pipe(gulp.dest('./assets/vendors/flag-icon-css/css'));
    var aStyle6 = gulp.src(['./node_modules/flag-icon-css/flags/**/*'])
        .pipe(gulp.dest('./assets/vendors/flag-icon-css/flags'));
    var aStyle7 = gulp.src(['./node_modules/simple-line-icons/css/simple-line-icons.css'])
        .pipe(gulp.dest('./assets/vendors/simple-line-icons/css'));
    var aStyle8 = gulp.src(['./node_modules/simple-line-icons/fonts/*'])
        .pipe(gulp.dest('./assets/vendors/simple-line-icons/fonts'));
    var aStyle9 = gulp.src(['./node_modules/ti-icons/css/themify-icons.css'])
        .pipe(gulp.dest('./assets/vendors/ti-icons/css'));
    var aStyle10 = gulp.src(['./node_modules/ti-icons/fonts/*'])
        .pipe(gulp.dest('./assets/vendors/ti-icons/fonts'));         
    var aStyle11 = gulp.src(['node_modules/fullcalendar/dist/fullcalendar.min.css'])
        .pipe(gulp.dest('./assets/vendors/fullcalendar'));
    var aStyle12 = gulp.src(['node_modules/c3/c3.min.css'])
        .pipe(gulp.dest('./assets/vendors/c3'));
    var aStyle13 = gulp.src(['node_modules/chartist/dist/chartist.min.css'])
        .pipe(gulp.dest('./assets/vendors/chartist'));
    var aStyle14 = gulp.src(['node_modules/morris.js/morris.css'])
        .pipe(gulp.dest('./assets/vendors/morris.js'));
    var aStyle15 = gulp.src(['node_modules/jquery-tags-input/dist/jquery.tagsinput.min.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-tags-input'));
    var aStyle16 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/fontawesome-stars.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle17 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/bars-1to10.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle18 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/bars-horizontal.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle19 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/bars-movie.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle20 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/bars-pill.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle21 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/bars-reversed.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle22 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/bars-square.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle23 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/bootstrap-stars.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle24 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/css-stars.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle25 = gulp.src(['node_modules/jquery-bar-rating/dist/themes/fontawesome-stars-o.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle26 = gulp.src(['node_modules/jquery-bar-rating/examples/css/examples.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var aStyle27 = gulp.src(['node_modules/dropify/dist/css/dropify.min.css'])
        .pipe(gulp.dest('./assets/vendors/dropify'));
    var aStyle28 = gulp.src(['node_modules/jquery-file-upload/css/uploadfile.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-file-upload'));
    var aStyle29 = gulp.src(['node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css'])
        .pipe(gulp.dest('./assets/vendors/tempusdominus-bootstrap-4'));
    var aStyle30 = gulp.src(['node_modules/jquery-asColorPicker/dist/css/asColorPicker.min.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-asColorPicker/css'));
    var aStyle31 = gulp.src(['node_modules/jquery-asColorPicker/dist/images/*'])
        .pipe(gulp.dest('./assets/vendors/jquery-asColorPicker/images'));
    var aStyle32 = gulp.src(['node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
        .pipe(gulp.dest('./assets/vendors/bootstrap-datepicker'));
    var aStyle33 = gulp.src(['node_modules/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css'])
        .pipe(gulp.dest('./assets/vendors/x-editable'));
    var aStyle34 = gulp.src(['node_modules/select2/dist/css/select2.min.css'])
        .pipe(gulp.dest('./assets/vendors/select2')); 
    var aStyle35 = gulp.src(['node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css'])
        .pipe(gulp.dest('./assets/vendors/select2-bootstrap-theme'));
    var aStyle36 = gulp.src(['node_modules/codemirror/lib/codemirror.css'])
        .pipe(gulp.dest('./assets/vendors/codemirror'));
    var aStyle37 = gulp.src(['node_modules/codemirror/theme/ambiance.css'])
        .pipe(gulp.dest('./assets/vendors/codemirror'));
    var aStyle38 = gulp.src(['node_modules/dropify/dist/css/dropify.min.css'])
        .pipe(gulp.dest('./assets/vendors/dropify'));
    var aStyle39 = gulp.src(['node_modules/quill/dist/quill.snow.css'])
        .pipe(gulp.dest('./assets/vendors/quill'));
    var aStyle40 = gulp.src(['node_modules/simplemde/dist/simplemde.min.css'])
        .pipe(gulp.dest('./assets/vendors/simplemde'));
    var aStyle41 = gulp.src(['node_modules/jvectormap/jquery-jvectormap.css'])
        .pipe(gulp.dest('./assets/vendors/jvectormap')); 
    var aStyle42 = gulp.src(['node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css'])
        .pipe(gulp.dest('./assets/vendors/datatables.net-bs4'));
    var aStyle43 = gulp.src(['node_modules/jsgrid/dist/jsgrid.min.css'])
        .pipe(gulp.dest('./assets/vendors/jsgrid'));
    var aStyle44 = gulp.src(['node_modules/jsgrid/dist/jsgrid-theme.min.css'])
        .pipe(gulp.dest('./assets/vendors/jsgrid'));
    var aStyle45 = gulp.src(['node_modules/owl-carousel-2/assets/owl.carousel.min.css'])
        .pipe(gulp.dest('./assets/vendors/owl-carousel-2'));
    var aStyle46 = gulp.src(['node_modules/owl-carousel-2/assets/owl.theme.default.min.css'])
        .pipe(gulp.dest('./assets/vendors/owl-carousel-2'));
    var aStyle47 = gulp.src(['node_modules/owl-carousel-2/assets/owl.video.play.png'])
        .pipe(gulp.dest('./assets/vendors/owl-carousel-2'));
    var aStyle48 = gulp.src(['node_modules/dragula/dist/dragula.min.css'])
        .pipe(gulp.dest('./assets/vendors/dragula')); 
    var aStyle49 = gulp.src(['node_modules/jquery-toast-plugin/dist/jquery.toast.min.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-toast-plugin'));
    var aStyle50 = gulp.src(['node_modules/nouislider/distribute/nouislider.min.css'])
        .pipe(gulp.dest('./assets/vendors/nouislider'));
    var aStyle51 = gulp.src(['node_modules/ion-rangeslider/css/ion.rangeSlider.css'])
        .pipe(gulp.dest('./assets/vendors/ion-rangeslider/css'));
    var aStyle52 = gulp.src(['node_modules/dropzone/dist/dropzone.css'])
        .pipe(gulp.dest('./assets/vendors/dropzone'));
    var aStyle53 = gulp.src(['node_modules/ion-rangeslider/img/*'])
        .pipe(gulp.dest('./assets/vendors/ion-rangeslider/img'));
    var aStyle54 = gulp.src(['node_modules/pwstabs/assets/jquery.pwstabs.min.css'])
        .pipe(gulp.dest('./assets/vendors/pwstabs'));
    var aStyle55 = gulp.src(['node_modules/jquery-contextmenu/dist/jquery.contextMenu.min.css'])
        .pipe(gulp.dest('./assets/vendors/jquery-contextmenu'));
    var aStyle56 = gulp.src(['node_modules/typicons.font/src/font/*'])
        .pipe(gulp.dest('./assets/vendors/typicons'));
    var aStyle57 = gulp.src(['./node_modules/jstree/dist/**/*'])
        .pipe(gulp.dest('./assets/vendors/jstree'));
    var aStyle58 = gulp.src(['./node_modules/puse-icons-feather/**/*'])
        .pipe(gulp.dest('./assets/vendors/puse-icons-feather'));
    return merge(aStyle1, aStyle2, aStyle3, aStyle4, aStyle5, aStyle6, aStyle7, aStyle8, aStyle9, aStyle10, aStyle11, aStyle12, aStyle13, aStyle14, aStyle15, aStyle16, aStyle17, aStyle18, aStyle19, aStyle20, aStyle21, aStyle22, aStyle23, aStyle24, aStyle25, aStyle26, aStyle27, aStyle28, aStyle29, aStyle30, aStyle31, aStyle32, aStyle33, aStyle34, aStyle35, aStyle36, aStyle37, aStyle38, aStyle39, aStyle40, aStyle41, aStyle42, aStyle43, aStyle44, aStyle45, aStyle46, aStyle47, aStyle48, aStyle49, aStyle50, aStyle51, aStyle52, aStyle53, aStyle54, aStyle55, aStyle56, aStyle57, aStyle58);
});

//Copy essential map files
gulp.task('copyMapFiles', function() {
    var map1 = gulp.src('node_modules/bootstrap/dist/js/bootstrap.min.js.map')
        .pipe(gulp.dest('./assets/vendors/js'));
    var map2 = gulp.src('node_modules/@mdi/font/css/materialdesignicons.min.css.map')
        .pipe(gulp.dest('./assets/vendors/mdi/css'));
    var map3 = gulp.src('node_modules/jquery-contextmenu/dist/jquery.contextMenu.min.css.map')
        .pipe(gulp.dest('./assets/vendors/jquery-contextmenu'));
    var map4 = gulp.src('node_modules/jquery-contextmenu/dist/jquery.contextMenu.min.js.map')
        .pipe(gulp.dest('./assets/vendors/jquery-contextmenu'));
    var map5 = gulp.src('node_modules/jquery-asColorPicker/dist/jquery-asColorPicker.min.js.map')
        .pipe(gulp.dest('./assets/vendors/jquery-asColorPicker'));
    var map6 = gulp.src('node_modules/jquery-asColorPicker/dist/css/asColorPicker.min.css.map')
        .pipe(gulp.dest('./assets/vendors/jquery-asColorPicker/css'));
    var map7 = gulp.src('node_modules/jquery-asColor/dist/jquery-asColor.min.js.map')
        .pipe(gulp.dest('./assets/vendors/jquery-asColor'));
    var map8 = gulp.src('node_modules/jquery-bar-rating/dist/jquery.barrating.min.js.map')
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var map9 = gulp.src('node_modules/jquery-asGradient/dist/jquery-asGradient.min.js.map')
        .pipe(gulp.dest('./assets/vendors/jquery-asGradient'));
    var map10 = gulp.src('node_modules/quill/dist/quill.min.js.map')
        .pipe(gulp.dest('./assets/vendors/quill'));
    var map11 = gulp.src('node_modules/chartist/dist/chartist.min.js.map')
        .pipe(gulp.dest('./assets/vendors/chartist'));
    var map12 = gulp.src('node_modules/jquery-bar-rating/dist/jquery.barrating.min.js.map')
        .pipe(gulp.dest('./assets/vendors/jquery-bar-rating'));
    var map13 = gulp.src('node_modules/lightgallery/src/css/lightgallery.css.map')
        .pipe(gulp.dest('./assets/vendors/lightgallery/'));
    return merge(map1, map2, map3, map4, map5, map6, map7, map8, map9, map10, map11, map12, map13);
});

/*sequence for building vendor scripts and styles*/
gulp.task('bundleVendors', gulp.series('clean:vendors', 'buildBaseVendorStyles','buildBaseVendorScripts', 'buildOptionalVendorStyles', 'buildOptionalVendorScripts', 'copyMapFiles'));