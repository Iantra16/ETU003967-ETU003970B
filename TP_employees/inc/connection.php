<?php
function dbconnect()
{
    static $bdd = null;

    if ($bdd === null) {
        $bdd = mysqli_connect('localhost', 'root', '', 'employees');
        // $bdd = mysqli_connect('localhost', 'ETU003970', '2qVrbh7m', 'db_s2_ETU003970');

        if (!$bdd) {
            // Arrête le script et affiche une erreur si la connexion échoue
            die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
        }

        // Optionnel : définir l'encodage des caractères pour gérer les accents (UTF-8 recommandé)
        mysqli_set_charset($bdd, 'utf8mb4');
    }

    return $bdd;
}

///////     VUE

$sql = "CREATE OR REPLACE VIEW v_manager_dept AS
SELECT e.*,d.dept_name,d.dept_no,de.to_date,de.from_date FROM employees e 
JOIN dept_manager de on e.emp_no = de.emp_no
JOIN departments d on de.dept_no = d.dept_no";
mysqli_query(dbconnect(), $sql);


$sql = "CREATE OR REPLACE VIEW v_manager_dept_current AS
SELECT * FROM v_manager_dept 
WHERE to_date = '9999-01-01'";
mysqli_query(dbconnect(), $sql);

$sql = "CREATE or replace view v_employees_Dept_current as 
SELECT * FROM v_employees_Dept where to_date = '9999-01-01'";
mysqli_query(dbconnect(), $sql);

$sql = "CREATE or replace view v_employees_fiche as 
SELECT e.emp_no,v1.salary, v2.title ,v1.to_date,v1.from_date,v3.dept_name FROM employees e 
JOIN v_salaries v1 on e.emp_no = v1.emp_no
JOIN v_titles v2 on e.emp_no = v2.emp_no
join v_employees_Dept_current v3 on v3.emp_no = e.emp_no";
mysqli_query(dbconnect(), $sql);

$sql = "CREATE or replace view v_titles as SELECT e.*,t.title,t.from_date,t.to_date from employees e
        join titles t on e.emp_no = t.emp_no";
mysqli_query(dbconnect(), $sql);

$sql = "CREATE or REPLACE view v_title_salary_emp as
SELECT t.title,
sum(s.salary)/count(s.salary) as moyenn,
count(t.emp_no) as nbre
 from employees e
join titles t on t.emp_no = e.emp_no
join salaries s on s.emp_no = e.emp_no
GROUP by t.title";
mysqli_query(dbconnect(), $sql);

$sql = "CREATE or REPLACE view v_gender as
SELECT t.title,
count(t.emp_no) as nbre,
e.gender as sexe
 from employees e
join titles t on t.emp_no = e.emp_no
join salaries s on s.emp_no = e.emp_no
GROUP by t.title,e.gender";
mysqli_query(dbconnect(), $sql);

$sql = "CREATE OR REPLACE VIEW v_long_durre AS
SELECT
    t.emp_no,
    t.title,
    t.from_date AS title_from_date,
    t.to_date AS title_to_date,
    DATEDIFF(
        CASE
            WHEN t.to_date = '9999-01-01' THEN CURDATE()
            ELSE t.to_date
        END,
        t.from_date
    ) AS duration_days
FROM
    titles t";
mysqli_query(dbconnect(), $sql);

$sql = "CREATE OR REPLACE VIEW v_titre_plusLong AS
SELECT
    l.emp_no as emp_no,
    l.title
FROM
    v_long_durre l
JOIN
    employees e ON l.emp_no = e.emp_no
WHERE
    l.duration_days = (
        SELECT MAX(duration_days)
        FROM v_long_durre
        WHERE emp_no = l.emp_no
    )
ORDER BY
    l.emp_no, l.title_from_date DESC";
mysqli_query(dbconnect(), $sql);
