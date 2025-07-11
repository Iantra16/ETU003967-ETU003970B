-- table
| current_dept_emp     |
| departments          |
| dept_emp             |
| dept_emp_latest_date |
| dept_manager         |
| employees            |
| salaries             |
| titles 


SELECT t.title,sum(s.salary)/count(e.emp_no),count(e.emp_no) from employees e
join titles t on t.emp_no = e.emp_no
join salaries s on s.emp_no = e.emp_no
where t.title='';



-- v_manager_dept
CREATE OR REPLACE VIEW v_manager_dept AS
SELECT e.*,d.dept_name,d.dept_no,de.to_date,de.from_date FROM employees e 
JOIN dept_manager de on e.emp_no = de.emp_no
JOIN departments d on de.dept_no = d.dept_no ;



-- v_manager_dept_current
CREATE OR REPLACE VIEW v_manager_dept_current AS
SELECT * FROM v_manager_dept 
WHERE to_date = '9999-01-01';

-- v_employees_Dept
create or replace view v_employees_Dept as 
SELECT e.*,de.from_date,de.to_date,d.dept_name,d.dept_no from employees e
        join dept_emp de on e.emp_no = de.emp_no
        join departments d on de.dept_no = d.dept_no;
        
--  v_employees_Dept_current
create or replace view v_employees_Dept_current as 
SELECT * FROM v_employees_Dept where to_date = '9999-01-01';

-- count employees PAR department
-- -- v_total_employees_dept 
-- CREATE OR REPLACE VIEW v_total_employees_dept AS
-- SELECT dept_name,dept_no, count(emp_no) AS nb_emp from v_employees_Dept_current GROUP BY dept_name ;

-- v_salaries 
CREATE OR REPLACE VIEW v_salaries AS
SELECT e.*,s.salary,s.from_date,s.to_date FROM salaries s 
JOIN employees e on s.emp_no = e.emp_no;

-- v_titles
create or replace view v_titles as SELECT e.*,t.title,t.from_date,t.to_date from employees e
        join titles t on e.emp_no = t.emp_no ;

SELECT distinct title form titles;

-- v_employees_fiche
create or replace view v_employees_fiche as 
SELECT e.emp_no,v1.salary, v2.title ,v2.to_date , v2.from_date FROM employees e 
JOIN v_salaries v1 on e.emp_no = v1.emp_no
JOIN v_titles v2 on e.emp_no = v2.emp_no
where v1.to_date = v2.to_date and v1.from_date = v2.from_date;


SELECT DATEDIFF(from_date,to_date) ,title from v_employees_fiche 
where emp_no = 210129;


-- v_age_emp_dep
CREATE OR REPLACE VIEW v_age_emp_dep AS
SELECT  dept_name,first_name,last_name,dept_no,
        TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age
        FROM v_employees_Dept;

-- nb_emp_par_titre 
CREATE OR REPLACE VIEW v_nb_emp_par_titre AS
SELECT count(t.emp_no),t.title,sum(s.salary)/count(s.emp_no) from v_titles t
join v_salaries s on t.emp_no = s.emp_no
 GROUP BY title;



SELECT * from v_nb_emp_par_titre;

-- titre && salary
CREATE or replace view v_titre_salary_emp 
as SELECT  t.title,
        sum(s.salary)/count(t.emp_no) as salarie_moyenne,
        count(t.emp_no) as nbre
 from employees e
join v_titles t on t.emp_no = e.emp_no
join v_salaries s on s.emp_no = e.emp_no
GROUP by t.title;

-- nb_gender_par_titre 
CREATE or REPLACE view v_nb_gender_par_titre AS
SELECT  count(emp_no),title,gender  from v_titles GROUP BY gender, title;

SELECT * FROM v_nb_gender_par_titre
WHERE gender = 'M';

-- salary title
SELECT * FROM salaries s
WHERE s.emp_no = '204717' and '1997-10-14' <= s.from_date and '9999-01-01' >= s.from_date;

SELECT DISTINCT(t.title) , count(s.salary) FROM titles t  join salaries s on t.emp_no = s.emp_no WHERE t.emp_no = '204717' ;


SELECT * FROM titles t 
JOIN employees e on t.emp_no = e.emp_no
JOIN salaries s on s.emp_no = e.emp_no
WHERE t.title = 'Manager' ;

CREATE or REPLACE view v_title_salary_emp as
SELECT t.title,
sum(s.salary)/count(s.salary) as moyenn,
count(t.emp_no) as nbre
 from employees e
join titles t on t.emp_no = e.emp_no
join salaries s on s.emp_no = e.emp_no
GROUP by t.title;


CREATE or REPLACE view v_gender as
SELECT t.title,
count(t.emp_no) as nbre,
e.gender as sexe
 from employees e
join titles t on t.emp_no = e.emp_no
join salaries s on s.emp_no = e.emp_no
GROUP by t.title,e.gender;

CREATE OR REPLACE VIEW v_long_durre AS
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
    titles t;


CREATE OR REPLACE VIEW v_titre_plusLong AS
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
    l.emp_no, l.title_from_date DESC;


SELECT * from v_employees_Dept_current where emp_no = '220771';
