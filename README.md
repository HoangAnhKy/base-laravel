# Chạy DB

```sh
php artisan migrate
```

# Web dùng để học laravel cơ bản

- Dùng Eloquent
- Có AUTH check login, có chia quyền cơ bản
    - Teacher: full quyền, CRUD course, CRUD User, CR course-detail
    - Student: CR Couse-detial
- Chức năng web
  - Course: thêm, xóa, sửa, tìm kiếm
  - User: thêm, xóa, sửa, tìm kiếm
  - Course-Detail: thêm sinh viên vô lớp, view
