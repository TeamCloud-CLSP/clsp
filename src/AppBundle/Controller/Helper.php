<?php

namespace AppBundle\Controller;


class Helper
{
    // for database access fields
    private static $app_users_columns = array(
        "id" => "id",
        "student_registration_id" => "student_registration_id",
        "username" => "username",
        "password" => "password",
        "email" => "email",
        "is_active" => "is_active",
        "date_created" => "date_created",
        "date_deleted" => "date_deleted",
        "date_start" => "date_start",
        "date_end" => "date_end",
        "timezone" => "timezone",
        "is_student" => "is_student",
        "is_professor" => "is_professor",
        "is_designer" => "is_designer",
        "forgot_password_key" => "forgot_password_key",
        "forgot_password_expiry" => "forgot_password_expiry",
        "is_administrator" => "is_administrator"
    );

    private static $classes_columns = array(
        "id" => "id",
        "course_id" => "course_id",
        "registration_id" => "registration_id",
        "name" => "name"
    );

    private static $courses_columns = array(
        "id" => "id",
        "designer_id" => "user_id",
        "name" => "name"
    );

    private static $professor_registrations_columns = array(
        "id" => "id",
        "owner_id" => "owner_id",
        "professor_id" => "professor_id",
        "course_id" => "course_id",
        "date_created" => "date_created",
        "date_deleted" => "date_deleted",
        "date_start" => "date_start",
        "date_end" => "date_end",
        "signup_code" => "signup_code"
    );

    private static $student_registrations_columns = array(
        "id" => "id",
        "designer_id" => "designer_id",
        "class_id" => "class_id",
        "prof_registration_id" => "prof_registration_id",
        "name" => "name",
        "date_created" => "date_created",
        "date_deleted" => "date_deleted",
        "date_start" => "date_start",
        "date_end" => "date_end",
        "signup_code" => "signup_code"
    );

    /**
     * @return array
     */
    public static function getAppUsersColumns()
    {
        return self::$app_users_columns;
    }

    /**
     * @return array
     */
    public static function getClassesColumns()
    {
        return self::$classes_columns;
    }

    /**
     * @return array
     */
    public static function getCoursesColumns()
    {
        return self::$courses_columns;
    }

    /**
     * @return array
     */
    public static function getProfessorRegistrationsColumns()
    {
        return self::$professor_registrations_columns;
    }

    /**
     * @return array
     */
    public static function getStudentRegistrationsColumns()
    {
        return self::$student_registrations_columns;
    }



}