<?php
defined('MOODLE_INTERNAL') || die();

function local_leccionmagica_extend_navigation(global_navigation $navigation) {
    global $PAGE;
    
    if ($PAGE->course->id == SITEID) {
        return;
    }
    
    $context = context_course::instance($PAGE->course->id);
    
    // Para profesores/docentes/administradores
    if (has_capability('moodle/course:update', $context)) {
        // Plan de Clase IA
        $url = new moodle_url('https://leccion-magica.vercel.app', ['role' => 'teacher']);
        $node = navigation_node::create(
            'Plan de Clase IA',
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'leccionmagica_teacher',
            new pix_icon('i/course', 'Plan de Clase IA')
        );
        $node->showinflatnavigation = true;
        $navigation->add_node($node);
        
        // Tutor del Curso (también para profesores)
        $url2 = new moodle_url('https://leccion-magica.vercel.app', ['role' => 'student']);
        $node2 = navigation_node::create(
            'Tutor del Curso',
            $url2,
            navigation_node::TYPE_CUSTOM,
            null,
            'leccionmagica_tutor',
            new pix_icon('i/user', 'Tutor del Curso')
        );
        $node2->showinflatnavigation = true;
        $navigation->add_node($node2);
    }
    // Para estudiantes
    else if (has_capability('mod/assign:submit', $context)) {
        $url = new moodle_url('https://leccion-magica.vercel.app', ['role' => 'student']);
        $node = navigation_node::create(
            'Tutor del Curso',
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'leccionmagica_student',
            new pix_icon('i/user', 'Tutor del Curso')
        );
        $node->showinflatnavigation = true;
        $navigation->add_node($node);
    }
}

function local_leccionmagica_extend_navigation_course($navigation, $course, $context) {
    // Para profesores/docentes/administradores - Mostrar AMBOS botones
    if (has_capability('moodle/course:update', $context)) {
        // Botón 1: Plan de Clase IA
        $url_teacher = new moodle_url('https://leccion-magica.vercel.app', ['role' => 'teacher']);
        $node_teacher = navigation_node::create(
            '🎓 Plan de Clase IA',
            $url_teacher,
            navigation_node::TYPE_CUSTOM,
            null,
            'leccionmagica_teacher',
            new pix_icon('i/course', 'Plan de Clase IA')
        );
        $navigation->add_node($node_teacher, null);
        
        // Botón 2: Tutor del Curso
        $url_student = new moodle_url('https://leccion-magica.vercel.app', ['role' => 'student']);
        $node_student = navigation_node::create(
            '🤖 Tutor del Curso',
            $url_student,
            navigation_node::TYPE_CUSTOM,
            null,
            'leccionmagica_student_teacher',
            new pix_icon('i/user', 'Tutor del Curso')
        );
        $navigation->add_node($node_student, null);
    }
    // Para estudiantes - Solo Tutor del Curso
    else if (has_capability('mod/assign:submit', $context)) {
        $url = new moodle_url('https://leccion-magica.vercel.app', ['role' => 'student']);
        $node = navigation_node::create(
            '🤖 Tutor del Curso',
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'leccionmagica_student',
            new pix_icon('i/user', 'Tutor del Curso')
        );
        $navigation->add_node($node, null);
    }
}