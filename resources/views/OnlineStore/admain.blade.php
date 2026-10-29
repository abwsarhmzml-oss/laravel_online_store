<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج</title>
    <link rel="stylesheet" href="{{ asset('css/css2/admain.css') }}">
</head>
<body>
    <div class="product-form-wrapper">
        <div class="product-form-header">
            <h1>إضافة منتج جديد</h1>
            <p>املأ البيانات أدناه لإضافة المنتج إلى القسم المطلوب</p>
        </div>

        <form class="product-form" action="{{ route('admain.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <label for="category">القسم</label>
                <select id="category" name="category" required>
                    <option value="">اختر القسم</option>
                    <option value="kids">Kids</option>
                    <option value="man">Man</option>
                    <option value="woman">Woman</option>
                    <option value="home">Home</option>
                </select>
            </div>

            <div class="form-row">
                <label for="name">اسم المنتج</label>
                <input id="name" name="name" type="text" placeholder="أدخل اسم المنتج" required>
            </div>

            <div class="form-row">
                <label for="price">السعر</label>
                <div class="input-group">
                    <span>د.ع</span>
                    <input id="price" name="price" type="number" step="0.01" min="0" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-row">
                <label for="image">صورة المنتج</label>
                <label class="file-upload" for="image">
                    <input id="image" name="image" type="file" accept="image/*" required>
                    <span>اختر الصورة</span>
                </label>
            </div>

            <div class="form-row">
                <label for="description">الوصف</label>
                <textarea id="description" name="description" placeholder="اكتب وصف المنتج هنا..." required></textarea>
            </div>

            <button type="submit">إضافة المنتج</button>
        </form>
    </div>
</body>
</html>
