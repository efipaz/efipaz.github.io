#!/bin/bash
# סקריפט ליצירת עמודי גלריה
# מייצר HTML עם כל התמונות בתיקייה

PICTURES_DIR="$1"
OUTPUT_FILE="$2"
TITLE="$3"
LANG="${4:-he}"

if [ -z "$PICTURES_DIR" ] || [ -z "$OUTPUT_FILE" ] || [ -z "$TITLE" ]; then
    echo "Usage: $0 <pictures_dir> <output_file> <title> [lang]"
    echo "Example: $0 travel/india/pictures travel/india/gallery-content.html 'אור הודו' he"
    exit 1
fi

BASE_DIR="/home/user/efipaz"
FULL_PICTURES_PATH="$BASE_DIR/$PICTURES_DIR"

# בדוק שהתיקייה קיימת
if [ ! -d "$FULL_PICTURES_PATH" ]; then
    echo "Error: Directory $FULL_PICTURES_PATH does not exist"
    exit 1
fi

# מיפוי שמות קטגוריות לעברית
declare -A CATEGORY_NAMES_HE=(
    ["Animals"]="חיות"
    ["Architecture"]="ארכיטקטורה"
    ["Art_and_Craft"]="אמנות ומלאכה"
    ["Children"]="ילדים"
    ["Colors"]="צבעים"
    ["Landscape"]="נוף"
    ["Openings"]="פתחים"
    ["Outside"]="בחוץ"
    ["People"]="אנשים"
    ["Portraits"]="דיוקנאות"
    ["Religion"]="דת ורוחניות"
    ["Tress_Flowers_and_Fruit"]="עצים פרחים ופירות"
    ["Animals_and_Plants"]="חיות וצמחים"
    ["Animals and Plants"]="חיות וצמחים"
    ["Daily_Life"]="חיי יומיום"
    ["Daily Life"]="חיי יומיום"
    ["Nature"]="טבע"
    ["Pagodas"]="פגודות"
)

echo "Generating gallery HTML..."
echo ""

# יצירת קובץ זמני לתוכן הגלריה
GALLERY_CONTENT=""

# סרוק קטגוריות
for category_dir in "$FULL_PICTURES_PATH"/*/; do
    [ -d "$category_dir" ] || continue

    category_name=$(basename "$category_dir")
    [ "$category_name" = "description.txt" ] && continue

    # תרגום שם הקטגוריה
    if [ "$LANG" = "he" ] && [ -n "${CATEGORY_NAMES_HE[$category_name]}" ]; then
        display_name="${CATEGORY_NAMES_HE[$category_name]}"
    else
        display_name=$(echo "$category_name" | tr '_' ' ')
    fi

    # ספור תמונות בקטגוריה
    image_count=$(find "$category_dir" -type f \( -name "*.jpg" -o -name "*.JPG" -o -name "*.jpeg" -o -name "*.png" \) 2>/dev/null | wc -l)

    [ "$image_count" -eq 0 ] && continue

    echo "  $category_name: $image_count images"

    # יצירת HTML לקטגוריה
    category_id=$(echo "$category_name" | tr '[:upper:]' '[:lower:]' | tr '_' '-')

    GALLERY_CONTENT+="
  <div class=\"gallery-section\" id=\"$category_id\">
    <div class=\"gallery-section__header\">
      <h3>$display_name <span class=\"gallery-section__count\">($image_count)</span></h3>
      <span class=\"gallery-section__toggle\"></span>
    </div>
    <div class=\"gallery-section__content\">
"

    # מצא תמונות (בתתי-תיקיות)
    while IFS= read -r img_path; do
        [ -z "$img_path" ] && continue
        # נתיב יחסי מתיקיית pictures
        rel_path="${img_path#$FULL_PICTURES_PATH/}"
        filename=$(basename "$img_path")

        GALLERY_CONTENT+="      <a href=\"pictures/$rel_path\" class=\"gallery__item\">
        <img data-src=\"pictures/$rel_path\" alt=\"$filename\" loading=\"lazy\">
      </a>
"
    done < <(find "$category_dir" -type f \( -name "*.jpg" -o -name "*.JPG" -o -name "*.jpeg" -o -name "*.png" \) | sort)

    GALLERY_CONTENT+="    </div>
  </div>
"
done

# שמור את התוכן
echo "$GALLERY_CONTENT" > "$BASE_DIR/$OUTPUT_FILE"

echo ""
echo "Gallery content saved to: $OUTPUT_FILE"
echo "Total categories: $(find "$FULL_PICTURES_PATH" -maxdepth 1 -type d | wc -l)"
echo "Total images: $(find "$FULL_PICTURES_PATH" -type f \( -name "*.jpg" -o -name "*.JPG" \) | wc -l)"
