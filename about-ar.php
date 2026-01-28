<?php include __DIR__.'/includes/head-ar.php'; ?>
<?php include __DIR__.'/includes/header-ar.php'; ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>من نحن | شوكولاتة Petrichoor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Tajawal', 'Cairo', sans-serif;
      background: linear-gradient(to bottom right, #e8f0e4, #f8f8f8);
      color: #333;
      direction: rtl;
      text-align: right;
    }
    .section-title {
      font-family: 'Amiri', serif;
      font-size: 2.8rem;
      color: #436b4b;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .highlight {
      color: #ff6600;
      font-weight: 600;
    }
    .content-box {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      padding: 2rem;
      margin-bottom: 2rem;
    }
    .section-dark {
      background-color: #1f3b2f;
      color: #fff;
      border-radius: 15px;
    }
    h5 {
      color: #ff6600;
      font-weight: 600;
      margin-top: 1rem;
    }
    .image-left {
      border-radius: 15px;
      width: 100%;
      height: auto;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    @media (max-width: 768px) {
      .about-row {
        flex-direction: column-reverse;
      }
      .image-left {
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <h1 class="section-title">من نحن؟</h1>

    <!-- About Section with Image on Left -->
    <div class="row align-items-center about-row mb-5">
      <div class="col-lg-3 mb-4 mb-lg-0">
        <img src="/petrichoor/assets/images/aboutpetrichoor.jpg" 
             alt="شوكولاتة فاخرة بطابع طبيعي" class="image-left">
      </div>
      <div class="col-lg-7">
        <div class="content-box">
          <h5>التميّز الفريد:</h5>
          <p>تتميز علامتنا بتنوعها وشمولها، حيث تجذب مختلف الأذواق والمناسبات.</p>

          <p><span class="highlight">صديقة للبيئة وفاخرة في آنٍ واحد:</span> تجمع العلامة بين البساطة والرفاهية في توازن جميل يعكس أناقتها عبر مجموعاتها المختلفة.</p>

          <p><span class="highlight">تناسب جميع المناسبات:</span> مثالية لكل الأوقات، سواء للاحتفالات الكبيرة أو كرمز بسيط للمحبة بين شخصين.</p>

          <p><span class="highlight">أخلاقية وصديقة للبيئة:</span> تلتزم العلامة بالممارسات الأخلاقية والبيئية، لتقدّم شوكولاتة صحية أكثر دون المساس بالمذاق الفاخر.</p>
        </div>
      </div>
    </div>

    <!-- Targeting All Ages -->
    <div class="content-box section-dark">
      <h5>استهداف جميع الفئات العمرية:</h5>
      <p>صُممت منتجات Petrichoor لتلائم جميع الأعمار، من الأطفال الذين يحبّون الطعم إلى الأهل الذين يثقون بالجودة وخيارات الحياة الصحية.</p>

      <h5>منتجات فاخرة:</h5>
      <p>للمناسبات الخاصة التي تتطلب الأفضل دائمًا، نقدّم شوكولاتة فاخرة تعبّر عن الاهتمام والذوق الرفيع.</p>

      <h5>خيارات صحية:</h5>
      <p>لعملائنا المهتمين بالصحة واللياقة، نقدم ابتكارات مذهلة تجمع بين الطعم اللذيذ والفوائد الصحية.</p>

      <h5>إبداعات مبتكرة:</h5>
      <p>تأسست العلامة على يد شابة مبدعة بدعم من والدتها وأحلام كبيرة، لتقدّم نكهات فريدة ومبتكرة تُحدث فرقًا في عالم الشوكولاتة.</p>

      <h5>تجديد مستمر:</h5>
      <p>نقدم باستمرار نكهات جديدة تبقي العلامة في صدارة عالم الشوكولاتة من حيث الإبداع والجرأة في الاختيارات.</p>

      <h5>هوية بصرية مميزة:</h5>
      <p>تعكس ألوان وتصاميم العلامة قيمها الجوهرية: الأصالة، الفخامة، اللمسة الطبيعية، الأناقة الأنثوية، والأفكار المبتكرة.</p>

      <h5>المرح والإبداع:</h5>
      <p>علامة مبتكرة تُلهم المرح والحيوية، وتقدّم شيئًا فريدًا لكل عميل ليجد فيها مرآة تعكس ذوقه وشخصيته.</p>
    </div>
  </div>

<?php include __DIR__.'/includes/footer-ar.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
